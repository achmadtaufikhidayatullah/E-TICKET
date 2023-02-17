@extends('backEnd.layouts.app')

@section('title', 'General Dashboard')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('library/izitoast/dist/css/iziToast.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('library/chocolat/dist/css/chocolat.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header shadow-lg">
            <h1>My Ticket</h1>
        </div>
        <div class="row">
            <div class="col-12">
                @if($errors->any())
                <div class="alert alert-danger">
                    Terdapat isian yang tidak valid. Silakan cek kembali isian Anda pada form pembayaran.<br>
                    <em>There is an invalid field. Please re-check your entries on the payment form.</em>
                </div>
                @endif
                @foreach($bookedTickets as $bookedTicket)
                <div class="card card-statistic-1 shadow-lg">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4 class="text-warning">Order Date : {{ $bookedTicket->created_at->isoFormat('Y/MM/DD hh:mm') }}</h4>
                                </div>
                                <div class="card-body">
                                    <span class="text-dark">{{ $bookedTicket->offline->name }}</span>
                                    <p class="text-small font-weight-bold">
                                    Event : {{ $bookedTicket->batch->event->name }} - {{ $bookedTicket->batch->name }}
                                    <br>
                                    Total : IDR {{ number_format($bookedTicket->sub_total + $bookedTicket->tax + $bookedTicket->unique_payment_code, 0, '', '.') }} / {{ $bookedTicket->quantity }} tickets (incl. tax)
                                    </p>
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
                                    <div class="row">
                                       <div class="col-6">
                                          <a href="{{ route('payments.invoice', $bookedTicket->payment->code) }}" class="btn btn-sm btn-primary w-100" target="_blank"><i class="fa-solid fa-file-invoice-dollar"></i> Invoice</a>
                                       </div>
                                       <div class="col-6">
                                          <a href="https://api.whatsapp.com/send?phone={{ $bookedTicket->offline->phone }}" class="btn btn-sm btn-success w-100" tabindex="_blank"><i class="fa-brands fa-whatsapp"></i> Chat</a>
                                       </div>
                                    </div>
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
                                    <small class="text-muted font-weight-bold text-small">Complete payment before ticket sold out</small>
                                    @elseif($bookedTicket->status == "validating_payment")
                                    <div class="badge badge-info">Validating Payment</div>
                                    <br>
                                    <small class="text-muted font-weight-bold text-small">Validating payment within 24 hours max</small>
                                    @elseif($bookedTicket->payment->status == "payment_successful")
                                    <div class="badge badge-success">Payment Successful</div>
                                    @else
                                    <div class="badge badge-danger">Book / Payment Rejected</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card-wrap">
                                <div class="card-header">
                                    
                                </div>
                                <div class="card-body text-right pb-3">
                                    @if($bookedTicket->status == "waiting_for_payment" || $bookedTicket->status == "payment_rejected")
                                    @if($bookedTicket->batch->isFull())
                                    <button disabled type="button" class="btn btn-secondary btn-lg btn-block text-dark disabled"><i class="fa fa-ban mr-1"></i> Sold Out</button>
                                    @else
                                    <button 
                                        data-code="{{ $bookedTicket->code }}" 
                                        data-unique-payment-code="{{ $bookedTicket->payment->unique_payment_code }}" 
                                        data-payment-total="{{ $bookedTicket->payment->grand_total }}" 
                                        data-toggle="modal" 
                                        data-target="#uploadPaymentReceiptModal" 
                                        type="button" 
                                        class="btn btn-warning btn-lg upload-payment btn-lg btn-block"><i class="fa fa-upload mr-1"></i> Bayar Tiket</button>
                                    @endif
                                    <a onclick="return confirm('Apakah anda yakin untuk membatalkan tiket yang telah dipesan?')" href="{{ route('ticket.cancel', $bookedTicket->code) }}" class="btn btn-danger btn-lg btn-block"><i class="fa fa-times mr-1"></i> Cancel Book</a>
                                    @elseif($bookedTicket->status == "validating_payment")
                                    <a href="{{ $bookedTicket->batch->event->whatsappLink() }}" class="btn btn-success btn-lg btn-block"><i class="fa-brands fa-whatsapp mr-1"></i> Contact CS</a>
                                    @elseif($bookedTicket->status == "payment_successful")
                                    <a target="_blank" href="{{ route('payments.invoice', $bookedTicket->payment->code) }}" class="btn btn-warning btn-lg btn-block"><i class="fa fa-file-invoice mr-1"></i> Download Invoice</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            
            <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <h3>Tampilan status "Waiting Validation"</h3>
                <div class="card card-statistic-1">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Order Date : - </h4>
                                </div>
                                <div class="card-body">
                                    <a href="#" class="text-dark">Yolo Fest - Early Bird</a>
                                    <p style="color: #98a6ad;font-size: 13px;line-height: 1.2;">Total : IDR 0000 (4
                                        tickets)</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Order Code</h4>
                                </div>
                                <div class="card-body">
                                    <p>YL1234</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Status</h4>
                                </div>
                                <div class="card-body">
                                    <div class="badge badge-warning">Waiting Validation</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card-wrap">
                                <div class="card-header">
                                    
                                </div>
                                <div class="card-body text-right pb-3">
                                    <a href="" class="btn btn-success btn-lg"><i class="fa-brands fa-whatsapp"></i> Contact CS</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card-icon bg-warning">
                        <i class="fas fa-star"></i>
                    </div> --}}
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <h3>Tampilan status "Payment Success"</h3>
                <div class="card card-statistic-1">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Order Date : - </h4>
                                </div>
                                <div class="card-body">
                                    <a href="#" class="text-dark">Yolo Fest - Early Bird</a>
                                    <p style="color: #98a6ad;font-size: 13px;line-height: 1.2;">Total : IDR 0000 (4
                                        tickets)</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Order Code</h4>
                                </div>
                                <div class="card-body">
                                    <p>YL1234</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Status</h4>
                                </div>
                                <div class="card-body">
                                    <div class="badge badge-success">Payment Success</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card-wrap">
                                <div class="card-header">
                                    
                                </div>
                                <div class="card-body text-right pb-3">
                                    <a href="" class="btn btn-primary btn-lg"><i class="fa-regular fa-envelope"></i> Re-Send Invoice</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card-icon bg-warning">
                        <i class="fas fa-star"></i>
                    </div> --}}
                </div>
            </div> -->
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
                        <div class="col-6">
                            <div class="form-group">
                                <label>
                                    Nama Bank <span class="text-danger">*</span><br>
                                    <em>Bank Name <span class="text-danger">*</span></em>
                                </label>
                                <input required type="hidden" name="bank_name" id="bank_name">
                                <select required data-bank="{{ auth()->user()->userBankAccount->bank_code ?? '' }}" name="bank_code" id="bank-options" class="form-control @error('bank_name') is-invalid @enderror"></select>
                                @error('bank_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>
                                    Nomor Rekening / Nomor E-wallet <span class="text-danger">*</span><br>
                                    <em>Account Number / E-wallet Number <span class="text-danger">*</span></em>
                                </label>
                                <input required type="text" class="form-control @error('account_number') is-invalid @enderror" name="account_number" value="{{ auth()->user()->userBankAccount->account_number ?? '' }}">
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
                        <input required type="text" class="form-control @error('account_holder_name') is-invalid @enderror" name="account_holder_name" value="{{ auth()->user()->userBankAccount->account_holder_name ?? '' }}">
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
                                    <li><strong>{{ $account->bank_name }} {{ $account->account_number }} a.n {{ $account->account_holder_name }}</strong></li>
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
                        <input required type="file" class="form-control @error('payment_proof') is-invalid @enderror" name="payment_proof">
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
                    <button type="button" class="btn btn-link text-warning btn-block" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/izitoast/dist/js/iziToast.min.js') }}"></script>
<script src="{{ asset('js/bank.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

<script>
    let code = ""
    let setBankOption = () => {
        $('#bank-options').empty()

        let userBankAccount = $('#bank-options').data('bank')
        let bankOptions = `<option value="" selected disabled>-- Select Bank --</option>`
        banks.forEach((item) => {
            bankOptions += `<option ${item.code == userBankAccount ? 'selected' : ''} value="${item.code}">${item.name}</option>`
        })

        $('#bank-options').append(bankOptions)
    }

    setBankOption()

    $('.upload-payment').on('click', function() {
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

    $('#bank-options').on('change', function() {
        setBankName()
    })
</script>

@if(session()->has('message'))
<script>
    let data = {
        message: "{{ session()->get('message') }}",
        status: "{{ session()->get('status') }}",
        position: 'topCenter',
    }
</script>
<script src="{{ asset('js/toastr.js') }}"></script>
@endif
@endpush
