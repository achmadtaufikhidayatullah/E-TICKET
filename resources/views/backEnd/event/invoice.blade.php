<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no"
        name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Invoice &mdash; Bubblix Creative</title>

    <!-- General CSS Files -->
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @stack('style')

    <!-- Template CSS -->
    <link rel="stylesheet"
        href="{{ asset('css/style.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/components.css') }}">
    
    <style type="text/css">
        @media print {
            #button-section {
                display: none;
            }
        }
    </style>

    <!-- Start GA -->
    <script async
        src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- END GA -->
</head>
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <!-- Content -->
            <div class="main-content px-5">
                <section class="section">
                    <div class="section-body">
                        <div id="button-section" class="text-right">
                            <button type="button" class="btn btn-primary btn-lg mb-3 print-button"><i class="fa fa-print mr-1"></i> Print</button>
                        </div>
                        <div class="invoice shadow-lg border border-warning">
                            <div class="invoice-print">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="invoice-title">
                                            <h2><img src="{{ asset('FrontAssets/img/logo.png') }}" alt="" width="120"></h2>
                                            <div class="invoice-number">Order Code: {{ $payment->code }}</div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <address>
                                                    <strong>Billed To:</strong><br>
                                                    {{ $payment->bookedTicket->user->name }}<br>
                                                    {{ $payment->bookedTicket->user->phone_number }}<br>
                                                    {{ $payment->bookedTicket->user->email }}<br>
                                                </address>
                                            </div>
                                            <div class="col-md-6 text-md-right">
                                                <address>
                                                    <strong>Book Date:</strong><br>
                                                    {{ $payment->bookedTicket->created_at->format('Y/m/d h:i') }}<br><br>
                                                </address>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <address>
                                                    <strong>Payment Method:</strong><br>
                                                    {{ $payment->bank_name }} {{ $payment->account_number }}<br>
                                                    A/N {{ $payment->account_holder_name }}
                                                </address>
                                            </div>
                                            <div class="col-md-6 text-md-right">
                                                <address>
                                                    <strong>Payment Status:</strong><br>
                                                    @if($payment->status == "waiting_for_payment")
                                                    <h5 class="my-1 font-weight-bold text-warning">Waiting For Payment</h5>
                                                    @elseif($payment->status == "validating_payment")
                                                    <h5 class="my-1 font-weight-bold text-info">Validating Payment</h5>
                                                    @elseif($payment->status == "payment_successful")
                                                    <h5 class="my-1 font-weight-bold text-success">Payment Successful</h5>
                                                    @else
                                                    <h5 class="my-1 font-weight-bold text-danger">Book / Payment Rejected</h5>
                                                    @endif
                                                </address>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="section-title">Order Summary</div>
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover table-md table">
                                                <tr>
                                                    <th data-width="40">#</th>
                                                    <th>Event</th>
                                                    <th>Batch</th>
                                                    <th class="text-center">Price (IDR)</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-right">Totals (IDR)</th>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>{{ $payment->bookedTicket->batch->event->name }}</td>
                                                    <td>{{ $payment->bookedTicket->batch->name }}</td>
                                                    <td class="text-center">{{ number_format($payment->bookedTicket->batch->price, 0, '', '.') }}</td>
                                                    <td class="text-center">{{ number_format($payment->bookedTicket->quantity, 0, '', '.') }}</td>
                                                    <td class="text-right">{{ number_format($payment->bookedTicket->sub_total, 0, '', '.') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-12 text-right">
                                                <div class="invoice-detail-item">
                                                    <div class="invoice-detail-name">Subtotal (IDR)</div>
                                                    <div class="invoice-detail-value">{{ number_format($payment->bookedTicket->sub_total, 0, '', '.') }}</div>
                                                </div>
                                                <div class="invoice-detail-item">
                                                    <div class="invoice-detail-name">Tax (IDR)</div>
                                                    <div class="invoice-detail-value">{{ number_format($payment->bookedTicket->tax, 0, '', '.') }}</div>
                                                </div>
                                                <div class="invoice-detail-item">
                                                    <div class="invoice-detail-name">Unique Payment Code (IDR)</div>
                                                    <div class="invoice-detail-value">{{ number_format($payment->unique_payment_code, 0, '', '.') }}</div>
                                                </div>
                                                <hr class="mt-2 mb-2">
                                                <div class="invoice-detail-item">
                                                    <div class="invoice-detail-name">Grand Total (IDR)</div>
                                                    <div class="invoice-detail-value invoice-detail-value-lg">{{ number_format($payment->grand_total, 0, '', '.') }}</div>
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
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.min.js')}}"></script>

    @stack('scripts')

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        $('.print-button').on('click', function() {
            window.print()
        })
    </script>
</body>

</html>
