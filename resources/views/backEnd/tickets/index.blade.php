@extends('backEnd.layouts.app')

@section('title', 'General Dashboard')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>My Order Tickets</h1>
        </div>
        <div class="row">
            <h3>Tampilan status "Waiting Payment"</h3>

            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
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
                                    <div class="badge badge-warning">Waiting Payment</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card-wrap">
                                <div class="card-header">
                                    
                                </div>
                                <div class="card-body text-right pb-3">
                                    <a href="" class="btn btn-primary btn-lg">upload payment receipt</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card-icon bg-warning">
                        <i class="fas fa-star"></i>
                    </div> --}}
                </div>
            </div>





            <h3>Tampilan status "Waiting Validation"</h3>

            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
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


            <h3>Tampilan status "Payment Success"</h3>

            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
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
            </div>
        </div>
    </section>
</div>
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
@endpush
