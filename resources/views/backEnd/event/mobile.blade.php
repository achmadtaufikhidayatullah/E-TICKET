@extends('backEnd.layouts.app')

@section('title', 'Events')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-12">
                @if($errors->any())
                <div class="alert alert-danger">
                    Terdapat isian yang tidak valid. Silakan cek kembali isian Anda pada form pembayaran.<br>
                    <em>There is an invalid field. Please re-check your entries on the payment form.</em>
                </div>
                @endif
                <div class="card shadow-lg">
                    <div class="card-body">
                        <ul class="nav nav-pills nav-fill" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ empty(request()->query('show')) || request()->query('show') == 'buyTicket' ? 'active' : '' }}"
                                    id="buy-ticket-tab" data-toggle="tab" href="#buy-ticket" role="tab"
                                    aria-controls="buy-ticket" aria-selected="true">Buy Ticket</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->query('show') == 'myTicket' ? 'active' : '' }}"
                                    id="my-ticket-tab" data-toggle="tab" href="#my-ticket" role="tab"
                                    aria-controls="my-ticket" aria-selected="true">My Ticket</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade {{ empty(request()->query('show')) || request()->query('show') == 'buyTicket' ? 'show active' : '' }}"
                                id="buy-ticket" role="tabpanel" aria-labelledby="buy-ticket-tab">
                                <h5 class="bg-white px-4 py-2 shadow text-dark rounded-pill m-auto"
                                    style="width: fit-content;">Ticket</h5>
                                <div class="row mt-4 mb-5">
                                    @forelse ($eventsBatch as $event)
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <a href="{{ $event->isFull() ? '#!' : route('events.form', $event->id) }}">
                                            <div class="card card-statistic-1 shadow-lg">
                                                @if($event->isFull())
                                                <div class="card-icon">
                                                    <span style="transform: rotate(-45deg) scale(1.25);"
                                                        class="badge badge-danger">Sold Out</span>
                                                </div>
                                                @else
                                                <div class="card-icon bg-warning">
                                                    <i class="fas fa-ticket"></i>
                                                </div>
                                                @endif
                                                <div class="card-wrap">
                                                    <div class="card-header pt-3 pb-0">
                                                        <!-- <h4>{{ date('d M Y', strtotime($event->start_date)) }} - {{ date('d M Y', strtotime($event->end_date)) }}</h4> -->
                                                    </div>
                                                    <div class="card-body mb-2">
                                                        <span style="font-size: 1rem;"
                                                            class="text-dark">{{ $event->event->name }} -
                                                            {{ $event->name }}</span>
                                                        <br>
                                                        <span class="text-small font-weight-bold">IDR
                                                            {{ number_format($event->price, 0, '', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    @empty
                                    <div class="col-lg-6 col-md-12 col-sm-12 text-center">
                                        <p>
                                            <span class="badge rounded-pill bg-danger text-white shadow">Ops! Nothing
                                                item is ready yet,<br>Stay Tune :)</span>
                                        </p>
                                    </div>
                                    @endforelse
                                </div>

                                {{-- merchandise --}}
                                <h5 class="bg-white px-4 py-2 shadow text-dark rounded-pill m-auto"
                                    style="width: fit-content;">Merchandise</h5>
                                <div class="row mt-4">
                                    @forelse ($merchandiseBatch as $event)
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <a href="{{ $event->isFull() ? '#!' : route('events.form', $event->id) }}">
                                            <div class="card card-statistic-1 shadow-lg">
                                                @if($event->isFull())
                                                <div class="card-icon">
                                                    <span style="transform: rotate(-45deg) scale(1.25);"
                                                        class="badge badge-danger">Sold Out</span>
                                                </div>
                                                @else
                                                <div class="card-icon bg-danger">
                                                    <i class="fas fa-shirt"></i>
                                                </div>
                                                @endif
                                                <div class="card-wrap">
                                                    <div class="card-header pt-3 pb-0">
                                                        <!-- <h4>{{ date('d M Y', strtotime($event->start_date)) }} - {{ date('d M Y', strtotime($event->end_date)) }}</h4> -->
                                                    </div>
                                                    <div class="card-body mb-2">
                                                        <span style="font-size: 1rem;"
                                                            class="text-dark">{{ $event->name }} -
                                                            {{ $event->event->name }}</span>
                                                        <br>
                                                        <span class="text-small font-weight-bold">IDR
                                                            {{ number_format($event->price, 0, '', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    @empty
                                    <div class="col-lg-6 col-md-12 col-sm-12 text-center">
                                        <p>
                                            <span class="badge rounded-pill bg-danger text-white shadow">Ops! Nothing
                                                item is ready yet,<br>Stay Tune :)</span>
                                        </p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="tab-pane fade {{ request()->query('show') == 'myTicket' ? 'show active' : '' }}"
                                id="my-ticket" role="tabpanel" aria-labelledby="record-evaluasi-tab">
                                <div class="row">
                                    <div class="col-12">
                                        @foreach($bookedTickets as $bookedTicket)
                                        <div class="card card-statistic-1 shadow-lg">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                                    <div class="card-wrap">
                                                        <div class="card-header">
                                                            <h4 class="text-warning">Order Date :
                                                                {{ $bookedTicket->created_at->isoFormat('Y/MM/DD hh:mm') }}
                                                            </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <span
                                                                class="text-dark">{{ $bookedTicket->batch->event->name }}
                                                                - {{ $bookedTicket->batch->name }}</span>
                                                            <p class="text-small font-weight-bold">Total : IDR
                                                                {{ number_format($bookedTicket->sub_total + $bookedTicket->tax + $bookedTicket->unique_payment_code, 0, '', '.') }}
                                                                / {{ $bookedTicket->quantity }} tickets (incl. tax)</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                                                    <div class="card-wrap">
                                                        <div class="card-header">
                                                            <h4 class="text-warning">Order Code</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <h4 class="text-dark">{{ $bookedTicket->code }}</h4>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                                    <div class="card-wrap">
                                                        <div class="card-header">
                                                            <h4 class="text-warning">Status</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            @if($bookedTicket->status == "waiting_for_payment")
                                                            <div class="badge badge-warning">Waiting For Payment</div>
                                                            <br>
                                                            <small
                                                                class="text-muted font-weight-bold text-small">Complete
                                                                payment before ticket sold out</small>
                                                            @elseif($bookedTicket->status == "validating_payment")
                                                            <div class="badge badge-info">Validating Payment</div>
                                                            <br>
                                                            <small
                                                                class="text-muted font-weight-bold text-small">Validating
                                                                payment within 24 hours max</small>
                                                            @elseif($bookedTicket->payment->status ==
                                                            "payment_successful")
                                                            <div class="badge badge-success">Payment Successful</div>
                                                            @else
                                                            <div class="badge badge-danger">Book / Payment Rejected
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                                    <div class="card-wrap">
                                                        <div class="card-header">

                                                        </div>
                                                        <div class="card-body text-right pb-3">
                                                            @if($bookedTicket->status == "waiting_for_payment" ||
                                                            $bookedTicket->status == "payment_rejected")
                                                            @if($bookedTicket->batch->isFull())
                                                            <button disabled type="button"
                                                                class="btn btn-secondary btn-lg btn-block text-dark disabled"><i
                                                                    class="fa fa-ban mr-1"></i> Sold Out</button>
                                                            @else
                                                            <button data-code="{{ $bookedTicket->code }}"
                                                                data-unique-payment-code="{{ $bookedTicket->payment->unique_payment_code }}"
                                                                data-payment-total="{{ $bookedTicket->payment->grand_total }}"
                                                                data-toggle="modal"
                                                                data-target="#uploadPaymentReceiptModal" type="button"
                                                                class="btn btn-warning btn-lg upload-payment btn-lg btn-block"><i
                                                                    class="fa fa-upload mr-1"></i> Bayar Tiket</button>
                                                            @endif
                                                            <a onclick="return confirm('Apakah anda yakin untuk membatalkan tiket yang telah dipesan?')"
                                                                href="{{ route('ticket.cancel', $bookedTicket->code) }}"
                                                                class="btn btn-danger btn-lg btn-block"><i
                                                                    class="fa fa-times mr-1"></i> Cancel Book</a>
                                                            @elseif($bookedTicket->status == "validating_payment")
                                                            <a href="{{ $bookedTicket->batch->event->whatsappLink() }}"
                                                                class="btn btn-success btn-lg btn-block"><i
                                                                    class="fa-brands fa-whatsapp mr-1"></i> Contact
                                                                CS</a>
                                                            @elseif($bookedTicket->status == "payment_successful")
                                                            <a target="_blank"
                                                                href="{{ route('payments.invoice', $bookedTicket->payment->code) }}"
                                                                class="btn btn-warning btn-lg btn-block"><i
                                                                    class="fa fa-file-invoice mr-1"></i> Download
                                                                Invoice</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<form id="upload-payment-form" action="#" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" tabindex="-1" role="dialog" id="uploadPaymentReceiptModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>
                                    Nama Bank <span class="text-danger">*</span><br>
                                    <em>Bank Name <span class="text-danger">*</span></em>
                                </label>
                                <input required type="hidden" name="bank_name" id="bank_name">
                                <select required
                                    data-bank="{{ auth()->user()->userBankAccount->bank_code ?? old('bank_code') }}"
                                    name="bank_code" id="bank-options"
                                    class="form-control @error('bank_name') is-invalid @enderror"></select>
                                @error('bank_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>
                                    Nomor Rekening / Nomor E-wallet <span class="text-danger">*</span><br>
                                    <em>Account Number / E-wallet Number <span class="text-danger">*</span></em>
                                </label>
                                <input required type="text"
                                    class="form-control @error('account_number') is-invalid @enderror"
                                    name="account_number"
                                    value="{{ auth()->user()->userBankAccount->account_number ?? old('account_number') }}">
                                @error('account_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            Nama Pemilik Rekening <span class="text-danger">*</span><br>
                            <em>Account Holder Name <span class="text-danger">*</span></em>
                        </label>
                        <input required type="text"
                            class="form-control @error('account_holder_name') is-invalid @enderror"
                            name="account_holder_name"
                            value="{{ auth()->user()->userBankAccount->account_holder_name ?? old('account_holder_name') }}">
                        @error('account_holder_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>
                                    Kode Pemesanan<br>
                                    <em>Order Code</em>
                                </label>
                                <h4 id="order_code">-</h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>
                                    Total Pembayaran<br>
                                    <em>Payment Total</em>
                                </label>
                                <h4 id="payment_total">-</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p style="line-height: 1.25;">
                                Silakan transfer ke salah satu rekening di bawah ini sesuai dengan total pembayaran<br>
                                <em>Please transfer the required payment into one of these available accounts</em>
                                <ul>
                                    @foreach($ownerAccounts as $account)
                                    <li><strong>{{ $account->bank_name }} {{ $account->account_number }} a.n
                                            {{ $account->account_holder_name }}</strong></li>
                                    @endforeach
                                </ul>
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            Bukti Pembayaran <span class="text-danger">*</span><br>
                            <em>Payment Receipt <span class="text-danger">*</span></em>
                        </label>
                        <input required type="file" class="form-control @error('payment_proof') is-invalid @enderror"
                            name="payment_proof">
                        @error('payment_proof')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        <small>Harap upload gambar dengan format .jpg / .png dengan ukuran maksimal 2MB</small><br>
                        <small><em>Please upload an image with .jpg / .png format with 2MB max size</em></small>
                    </div>
                    <div class="form-group">
                        <label>
                            <span class="text-danger">*</span> wajib diisi <br>
                            <em><span class="text-danger">*</span> required field</em>
                        </label>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button id="upload-button" type="submit" class="btn btn-warning btn-block">Upload</button>
                    <button type="button" class="btn btn-link text-warning btn-block"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
<script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/index-0.js') }}"></script>

<script src="{{ asset('js/bank.js') }}"></script>

<script>
    let code = ""
    let setBankOption = () => {
        $('#bank-options').empty()

        let userBankAccount = $('#bank-options').data('bank')
        let bankOptions = `<option value="" selected disabled>-- Select Bank --</option>`
        banks.forEach((item) => {
            bankOptions +=
                `<option ${item.code == userBankAccount ? 'selected' : ''} value="${item.code}">${item.name}</option>`
        })

        $('#bank-options').append(bankOptions)
    }

    setBankOption()

    $('.upload-payment').on('click', function () {
        code = $(this).data('code')
        // let uniquePaymentCode = $(this).data('unique-payment-code')
        let paymentTotal = $(this).data('payment-total')

        // $('#unique_payment_code').text(uniquePaymentCode)
        $('#order_code').text(code)
        $('#payment_total').text('IDR ' + (paymentTotal).toLocaleString("id"))

        let url = "{{ route('payments.upload', 'xxx') }}".replace('xxx', code)
        let form = $('#upload-payment-form')
        form.attr('action', url)
    })

    let setBankName = () => {
        let bankName = $("#bank-options option:selected").text()
        $('#bank_name').val(bankName)
    }

    setBankName()

    $('#bank-options').on('change', function () {
        setBankName()
    })

</script>
@endpush
