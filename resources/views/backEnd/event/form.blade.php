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
            <h1>{{ $batch->events->name }} - {{ $batch->name }}</h1>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="mb-4">
                                <label for="exampleInputEmail1" class="form-label"><b>Your Name</b></label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Your Full Name" required>
                                <div id="emailHelp" class="form-text">Please make sure that the name is the same as your
                                    KTP.</div>
                            </div>

                            <div class="mb-4">
                                <label for="exampleInputPassword1" class="form-label"><b>Identity Number</b></label>
                                <input type="text" class="form-control" id="exampleInputPassword1"
                                    placeholder="KTP Number or Other Identity Number" required>
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

                            <div class="mb-4">
                                <label for="exampleInputPassword1" class="form-label"><b>Number of tickets</b></label>
                                <input type="number" class="form-control" id="exampleInputPassword1" min="1" value="1"
                                    placeholder="Your Phone Number" required>
                            </div>

                            <input type="hidden" name="event_batch_id" value="{{ $batch->id }}">

                            <button type="submit" class="btn btn-primary">Buy Now</button>
                        </form>
                    </div>
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
