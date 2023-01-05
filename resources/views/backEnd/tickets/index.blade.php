@extends('backEnd.layouts.app')

@section('title', 'General Dashboard')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('library/izitoast/dist/css/iziToast.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header shadow-lg">
            <h1>My Ticket</h1>
        </div>
        <div class="row">
            <div class="col-12">
                @foreach($bookedTickets as $bookedTicket)
                <div class="card card-statistic-1 shadow-lg">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4 class="text-warning">Order Date : {{ $bookedTicket->created_at->isoFormat('Y/MM/DD hh:mm') }}</h4>
                                </div>
                                <div class="card-body">
                                    <span class="text-dark">Yolo Fest - Early Bird</span>
                                    <p class="text-small font-weight-bold">Total : IDR {{ number_format($bookedTicket->sub_total + $bookedTicket->tax, 0, '', '.') }} / {{ $bookedTicket->quantity }} tickets (incl. tax)</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
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
                                    <small class="text-muted font-weight-bold text-small">Complete payment before {{ $bookedTicket->created_at->addHours(23)->format('Y/m/d h:i') }}</small>
                                    @elseif($bookedTicket->status == "validating_payment")
                                    <div class="badge badge-warning">Validating Payment</div>
                                    @elseif($bookedTicket->status == "payment_successful")
                                    <div class="badge badge-warning">Validating Payment</div>
                                    @else
                                    -
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card-wrap">
                                <div class="card-header">
                                    
                                </div>
                                <div class="card-body text-right pb-3">
                                    @if($bookedTicket->status == "waiting_for_payment")
                                    <button 
                                        data-code="{{ $bookedTicket->code }}" 
                                        data-unique-payment-code="{{ $bookedTicket->payment->unique_payment_code }}" 
                                        data-payment-total="{{ $bookedTicket->payment->grand_total }}" 
                                        data-toggle="modal" 
                                        data-target="#uploadPaymentReceiptModal" 
                                        type="button" 
                                        class="btn btn-warning btn-lg upload-payment">Upload Payment Receipt</button>
                                    @elseif($bookedTicket->status == "validating_payment")
                                    <a href="" class="btn btn-success btn-lg"><i class="fa-brands fa-whatsapp"></i> Contact CS</a>
                                    @elseif($bookedTicket->status == "payment_successful")
                                    <a type="button" class="btn btn-primary btn-lg"><i class="fa-regular fa-envelope"></i> Re-Send Invoice</a>
                                    @else
                                    -
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
                                <label>Bank</label>
                                <input type="hidden" name="bank_name" id="bank_name">
                                <select name="bank_code" id="bank-options" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Account Number</label>
                                <input type="text" class="form-control" name="account_number" value="{{ auth()->user()->userBankAccount->account_number ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Account Holder Name</label>
                        <input type="text" class="form-control" name="account_holder_name" value="{{ auth()->user()->userBankAccount->account_holder_name ?? '' }}">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Unique Payment Code</label>
                                <h4 id="unique_payment_code">-</h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Payment Total</label>
                                <h4 id="payment_total">-</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p>Please transfer the required payment into one of these available accounts:
                                <ul>
                                    @foreach($ownerAccounts as $account)
                                    <li><strong>{{ $account->bank_name }} {{ $account->account_number }} a.n {{ $account->account_holder_name }}</strong></li>
                                    @endforeach
                                </ul>
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Payment Receipt</label>
                        <input type="file" class="form-control" name="payment_proof">
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-link text-warning" data-dismiss="modal">Close</button>
                    <button id="upload-button" type="button" class="btn btn-warning">Upload</button>
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

<script>
    let code = ""
    let setBankOption = () => {
        $('#bank-options').empty()
        let bankOptions = `<option value="" selected disabled>-- Select Bank --</option>`
        banks.forEach((item) => {
            bankOptions += `<option value="${item.code}">${item.name}</option>`
        })
        $('#bank-options').append(bankOptions)
    }

    setBankOption()

    $('.upload-payment').on('click', function() {
        code = $(this).data('code')
        let uniquePaymentCode = $(this).data('unique-payment-code')
        let paymentTotal = $(this).data('payment-total')

        $('#unique_payment_code').text(uniquePaymentCode)
        $('#payment_total').text('IDR ' + (paymentTotal).toLocaleString("id"))
    })

    $('#bank-options').on('change', function() {
        let bankName = $("#bank-options option:selected").text()
        $('#bank_name').val(bankName)
    })

    $('#upload-button').on('click', function() {
        let url = "{{ route('payments.upload', '69') }}".replace('69', code)
        let form = $('#upload-payment-form')
        form.attr('action', url)
        form.submit()
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
