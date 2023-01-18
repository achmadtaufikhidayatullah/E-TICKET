@extends('backEnd.layouts.app')

@section('title', 'On-Sale Events')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/izitoast/dist/css/iziToast.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header shadow-lg">
            <h1>On-Sale Events</h1>
        </div>
        <div class="row">
            @foreach ($eventsBatch as $event)
            <div class="col-lg-6 col-md-12 col-sm-12">
                <a href="{{ $event->isFull() ? '#!' : route('events.form', $event->id) }}">
                    <div class="card card-statistic-1 shadow-lg">
                        @if($event->isFull())
                        <div class="card-icon">
                            <span style="transform: rotate(-45deg) scale(1.25);" class="badge badge-danger">Sold Out</span>
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
                                <span style="font-size: 1rem;" class="text-dark">{{ $event->event->name }} - {{ $event->name }}</span>
                                <br>
                                <span class="text-small font-weight-bold">IDR {{ number_format($event->price, 0, '', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/izitoast/dist/js/iziToast.min.js') }}"></script>
<script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/index-0.js') }}"></script>

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
