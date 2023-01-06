@extends('frontEnd.layout.tamplate')


@section('content')
<div class="container">
    <div class="card w-50 m-auto shadow p-4 card-100-mobile">
        <div class="text-center">
            <h4>Re-send Email Verification has been successful!!</h4>
        </div>
        <div class="card-body mt-3 text-center">
            <p>please check your email to verify your account
               <br>
               If the email is still not received within 10 minutes at the latest, please try again.
            </p>
        </div>
    </div>
</div>


@endsection
