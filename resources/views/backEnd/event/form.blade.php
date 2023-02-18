@extends('backEnd.layouts.app')

@section('title', 'Book Ticket')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/izitoast/dist/css/iziToast.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header shadow-lg">
            <h1>Book Ticket</h1>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                @if ($batch->kupon_status == 'Aktif')
                <div class="card shadow-lg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 mt-2">
                                <form action="{{ route('events.cekKupon', $batch->id) }}" method="POST">
                                    @csrf
                                    @if ($batch->kupon->tipe_kupon == 'Ticket Code')
                                    <label for="inputPhoneNumber">Enter your
                                        <b>Early Bird or {{ $batch->kupon->eventBatch->name }}</b> order code to get a
                                        discount</label>
                                    @else
                                    <label for="inputPhoneNumber">Enter your coupon code to get a discount</label>
                                    @endif
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control {{ ($kupon_digunakan == 1) ? 'disabled' : '' }}"
                                            placeholder="{{ $batch->kupon->tipe_kupon == 'Ticket Code' ? 'Your Order Code' : 'Your Coupon Code' }}"
                                            aria-label="Recipient's username" aria-describedby="button-addon2"
                                            name="kupon_code" value="{{ $kupon_code }}" id="kupon_code"  {{ ($kupon_digunakan == 1) ? 'readonly' : '' }}>
                                        @if ($kupon_digunakan == 1)
                                       <div class="input-group-append">
                                          <a class="btn btn-outline-warning" href="{{ route('remove.coupons') }}"
                                             id="button-addon2">Remove Coupons</a>
                                       </div>  
                                        @else
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-warning" type="submit"
                                                id="button-addon2">Check coupons</button>
                                        </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="card shadow-lg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mt-2">
                                @if($batch->image == NULL)
                                <img class="img-fluid" src="{{ asset('FrontAssets/img/BG.jpg') }}">
                                @else
                                <img src="{{ asset('storage/batch/' . $batch->image) }}" style="width:100%;">
                                @endif
                            </div>
                            <div class="col-md-6 col-sm-12 mt-2">
                                <h1 style="font-size: 1.8rem;">{{ $batch->event->name }}</h1>
                                <h5 style="font-size: 1.2rem;">Batch: {{ $batch->name }}</h5>
                                <div class="form-group">
                                    <label for="inputNumberOfTickets">Number of Tickets</label>
                                    <input type="number" class="form-control" id="inputNumberOfTickets" min="1"
                                        max="{{ $max_code }}" value="1">
                                </div>
                                <form action="{{ route('events.purchase', $batch->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" id="quantity">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <input type="hidden" name="kode_kupon" value="{{ $kupon_code }}">
                                                        <div class="col-6">Price Per Ticket (IDR)</div>
                                                        @if ($kupon_digunakan == 1)
                                                        <div class="col-6 font-weight-bold"><span id="price"
                                                                data-price="{{ $batch->price - $batch->kupon->value }}">
                                                                <del class="text-muted">{{ number_format($batch->price, 0, '', '.') }}</del> {{ number_format($batch->price - $batch->kupon->value, 0, '', '.') }}</span>
                                                        </div>
                                                        @else
                                                        <div class="col-6 font-weight-bold"><span id="price"
                                                                data-price="{{ $batch->price }}">
                                                                {{ number_format($batch->price, 0, '', '.') }}</span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-6">Qty</div>
                                                        <div class="col-6 font-weight-bold" id="col-qty"></div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-6">Sub Total</div>
                                                        <div class="col-6 font-weight-bold" id="col-sub-total"></div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-6">Fee Admin <span id="tax-percentage"
                                                                data-tax="{{ $setting->tax_percentage }}">({{ $setting->tax_percentage }}%)</span>
                                                        </div>
                                                        <div class="col-6 font-weight-bold" id="col-tax"></div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-6">Grand Total</div>
                                                        <div class="col-6 font-weight-bold" id="col-grand-total"></div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-warning btn-block btn-lg mt-2"><i
                                                    class="fas fa-ticket mr-2"></i> Book Now</button>
                                            @mobile
                                            <a href="{{ route('events.index') }}"
                                                class="btn btn-block btn-link text-warning btn-lg mt-2"><i
                                                    class="fas fa-reply mr-2"></i> Back to My Ticket</a>
                                            @elsemobile
                                            <a href="{{ route('ticket.index') }}"
                                                class="btn btn-block btn-link text-warning btn-lg mt-2"><i
                                                    class="fas fa-reply mr-2"></i> Back to My Ticket</a>
                                            @endmobile
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/izitoast/dist/js/iziToast.min.js') }}"></script>
<!-- Page Specific JS File -->
<script>
    let numberOfTickets = $('#inputNumberOfTickets').val()
    let calculateSubTotal = (numberOfTickets) => {
        let price = $('#price').data('price')
        let taxPercentage = $('#tax-percentage').data('tax')

        if (numberOfTickets < 1) {
            numberOfTickets = 1;
        }

        let subTotal = numberOfTickets * price
        let tax = Math.round((taxPercentage / 100) * subTotal)
        let grandTotal = subTotal + tax

        $('#quantity').val(numberOfTickets)
        $('#col-qty').text(numberOfTickets)
        $('#col-sub-total').text(subTotal.toLocaleString("id"))
        $('#col-tax').text(tax.toLocaleString("id"))
        $('#col-grand-total').text(grandTotal.toLocaleString("id"))
    }

    calculateSubTotal(numberOfTickets)

    $('.go-to-checkout').on('click', function () {
        $('.nav-tabs a[href="#checkout"]').tab('show');
    })

    $('.go-to-event-detail').on('click', function () {
        $('.nav-tabs a[href="#event-detail"]').tab('show');
    })

    $('#inputNumberOfTickets').on('keyup keypress keydown change', function () {
        let maxCode = $('#inputNumberOfTickets').attr('max')
        numberOfTickets = $(this).val()
        $('#quantity').val(numberOfTickets)

        if ($(this).val() < 1) {
            $('#checkout-tab').prop('disabled', true)
            $('.go-to-checkout').prop('disabled', true)
            $('.go-to-checkout').addClass('disabled')
        } else {
            $('#checkout-tab').prop('disabled', false)
            $('.go-to-checkout').prop('disabled', false)
            $('.go-to-checkout').removeClass('disabled')
        }

        if (numberOfTickets > maxCode) {
            numberOfTickets = maxCode
            $(this).val(maxCode)
        }

        calculateSubTotal(numberOfTickets)
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
