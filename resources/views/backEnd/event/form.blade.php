@extends('backEnd.layouts.app')

@section('title', 'Book Ticket')

@push('style')
<!-- CSS Libraries -->
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
                        <ul class="nav nav-tabs nav-fill"
                            id="myTab2"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active"
                                    id="event-detail-tab"
                                    data-toggle="tab"
                                    href="#event-detail"
                                    role="tab"
                                    aria-controls="event-detail"
                                    aria-selected="true">Event Detail</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    id="checkout-tab"
                                    data-toggle="tab"
                                    href="#checkout"
                                    role="tab"
                                    aria-controls="checkout"
                                    aria-selected="true">Checkout</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered"
                            id="myTab3Content">
                            <div class="tab-pane fade show active"
                                id="event-detail"
                                role="tabpanel"
                                aria-labelledby="event-detail-tab">
                                <div class="row">
                                    <div class="col-6">
                                        @if($batch->event->image == NULL)
                                        <img class="img-fluid" src="{{ asset('FrontAssets/img/BG.jpg') }}">
                                        @else
                                        <img src="{{ asset('storage/event/' . $batch->event->image) }}">
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <h1>{{ $batch->event->name }}</h1>
                                        <h5>Batch: {{ $batch->name }} (IDR <span id="price" data-price="{{ $batch->price }}">{{ number_format($batch->price, 0, '', '.') }})</span></h5>
                                        <div class="form-group">
                                            <label for="inputNumberOfTickets">Number of Tickets</label>
                                            <input type="number" class="form-control" id="inputNumberOfTickets" min="1" max="9999" value="1">
                                            <button type="button" class="btn btn-warning btn-lg btn-block mt-2 go-to-checkout"><i class="fas fa-arrow-right mr-2"></i> Go to Checkout</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade"
                                id="checkout"
                                role="tabpanel"
                                aria-labelledby="record-evaluasi-tab">
                                <h4 class="mt-3 mb-3">Checkout</h4>
                                <form action="{{ route('events.purchase', $batch->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" id="quantity">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Event</th>
                                                <th>Batch</th>
                                                <th class="text-right">Price Per Ticket (IDR)</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-right">Sub Total (IDR)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>{{ $batch->event->name }}</td>
                                                <td>{{ $batch->name }}</td>
                                                <td class="text-right">{{ number_format($batch->price, 0, '', '.') }}</td>
                                                <td class="text-center" id="col-qty"></td>
                                                <td class="text-right" id="col-sub-total"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right font-weight-bold" colspan="5">Tax (<span id="tax-percentage" data-tax="{{ $setting->tax_percentage }}"></span>{{ $setting->tax_percentage }}%)</td>
                                                <td class="text-right" id="col-tax">12345</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right font-weight-bold" colspan="5">Grand Total</td>
                                                <td class="text-right" id="col-grand-total">12345</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-link btn-block btn-lg mt-2 go-to-event-detail"><i class="fas fa-arrow-left mr-2"></i> Back to Event Detail</button>
                                        </div>
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-warning btn-block btn-lg mt-2"><i class="fas fa-ticket mr-2"></i> Purchase Ticket</button>
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

<!-- Page Specific JS File -->
<script>
    let numberOfTickets = $('#inputNumberOfTickets').val()
    let calculateSubTotal = (numberOfTickets) => {
        let price = $('#price').data('price')
        let taxPercentage = $('#tax-percentage').data('tax')

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

    $('#inputNumberOfTickets').on('keyup keypress keydown', function() {
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
@endpush
