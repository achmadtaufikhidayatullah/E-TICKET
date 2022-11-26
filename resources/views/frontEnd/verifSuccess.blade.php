@extends('frontEnd.layout.tamplate')


@section('content')
<div class="container">
    <div class="card w-50 m-auto shadow p-4 card-100-mobile">
        <div class="text-center">
            <h2>Hey, {{ $name }}</h2>
        </div>
        <div class="card-body mt-3 text-center">
            <p>Your account has been verified</p>
            <p>Please proceed to the <a href="{{ route('login') }}">login page</a>. thanks !</p>
        </div>
    </div>
</div>


@endsection
