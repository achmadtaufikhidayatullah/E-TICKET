@extends('frontEnd.layout.tamplate')


@section('content')
<div class="container">
    <div class="title-ticket mb-5">
      <div class="card text-center m-auto w-25 p-2 shadow border-0">
         <h3>TICKET ON SALE</h3>
      </div>
    </div>
    <div class="row">
        <div class="col-lg-4 mt-3">
            <div class="card bg-white text-white shadow rounded-3">
                <img src="{{ asset('FrontAssets/img/images.jpeg') }}" class="card-img rounded-3" alt="..." height="278">
                <div class="card-img-overlay text-dark rounded-3">
                  <div class="position-absolute" style="bottom: 16px;padding-right: 16px;">
                     <h5 class="card-title">Card title</h5>
                     <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                         additional content. This content is a little bit longer.</p>
                     <p class="card-text">Last updated 3 mins ago</p>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-3">
            <div class="card bg-white text-white shadow rounded-3">
                <img src="{{ asset('FrontAssets/img/background.jpg') }}" class="card-img rounded-3" alt="..." height="278">
                <div class="card-img-overlay text-dark rounded-3">
                  <div class="position-absolute" style="bottom: 16px;padding-right: 16px;">
                     <h5 class="card-title">Card title</h5>
                     <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                         additional content. This content is a little bit longer.</p>
                     <p class="card-text">Last updated 3 mins ago</p>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('bottom')

@endpush


@endsection
