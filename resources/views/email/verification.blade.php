@php
      $url = route('regist.verification' , $id);
@endphp

@component('mail::message')
   <h1>Verification Your Email</h1>
   <p>Thank you for registering on the bubblix.id website. Please verify your account by pressing the button below.</p>

   @component('mail::button', ['url' => $url])
      Verify Your Account
   @endcomponent
@endcomponent