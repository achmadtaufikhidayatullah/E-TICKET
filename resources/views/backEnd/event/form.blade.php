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
                {{-- <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="mb-4">
                                <label for="exampleInputEmail1" class="form-label"><b>Your Name</b></label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Your Full Name" readonly value="{{ auth()->user()->name }}">
                            </div>

                            <div class="mb-4">
                                <label for="exampleInputPassword1" class="form-label"><b>Identity Number</b></label>
                                <input type="text" class="form-control" id="exampleInputPassword1"
                                    placeholder="KTP Number or Other Identity Number" readonly value="{{ auth()->user()->no_ktp }}">
                            </div>

                            <div class="mb-4">
                                <label for="exampleInputPassword1" class="form-label"><b>Address</b></label>
                                <input type="text" class="form-control" id="exampleInputPassword1"
                                    placeholder="Your Address" required>
                            </div>

                            <div class="mb-4">
                                <label for="exampleInputPassword1" class="form-label"><b>Phone Number</b></label>
                                <input type="number" class="form-control" id="exampleInputPassword1"
                                    placeholder="Your Phone Number" required>
                            </div>
                        </form>
                    </div>
                </div> --}}

                <div class="card shadow-lg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mt-2">
                                @if($batch->event->image == NULL)
                                <img class="img-fluid" src="{{ asset('FrontAssets/img/BG.jpg') }}">
                                @else
                                <img src="{{ asset('storage/event/' . $batch->event->image) }}" style="width:100%;">
                                @endif
                            </div>
                            <div class="col-md-6 col-sm-12 mt-2">
                                <h1 style="font-size: 1.8rem;">{{ $batch->event->name }}</h1>
                                <h5 style="font-size: 1.2rem;">Batch: {{ $batch->name }}</h5>
                                <div class="form-group">
                                    <label for="inputNumberOfTickets">Number of Tickets</label>
                                    <input type="number" class="form-control" id="inputNumberOfTickets" min="1" max="9999" value="1">
                                </div>
                                <form action="{{ route('events.purchase', $batch->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" id="quantity">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-6">Price Per Ticket (IDR)</div>
                                                        <div class="col-6 font-weight-bold"><span id="price" data-price="{{ $batch->price }}">{{ number_format($batch->price, 0, '', '.') }}</span></div>
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
                                                        <div class="col-6">Tax <span id="tax-percentage" data-tax="{{ $setting->tax_percentage }}">({{ $setting->tax_percentage }}%)</span></div>
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
                                            <button type="submit" class="btn btn-warning btn-block btn-lg mt-2"><i class="fas fa-ticket mr-2"></i> Book Now</button>
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

        if(numberOfTickets < 1) {
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

    $('.go-to-checkout').on('click', function() {
        $('.nav-tabs a[href="#checkout"]').tab('show');
    })

    $('.go-to-event-detail').on('click', function() {
        $('.nav-tabs a[href="#event-detail"]').tab('show');
    })

    $('#inputNumberOfTickets').on('keyup keypress keydown change', function() {
        numberOfTickets = $(this).val()
        $('#quantity').val(numberOfTickets)

        if($(this).val() < 1) {
            $('#checkout-tab').prop('disabled', true)
            $('.go-to-checkout').prop('disabled', true)
            $('.go-to-checkout').addClass('disabled')
        } else {
            $('#checkout-tab').prop('disabled', false)
            $('.go-to-checkout').prop('disabled', false)
            $('.go-to-checkout').removeClass('disabled')
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
