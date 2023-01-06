@component('mail::message')
   <h1>Reset Password</h1>
   <p>reset your password by clicking the link below. if this password reset request is not from you, just ignore this email.</p>

   @component('mail::button', ['url' => $link])
      Your Invoice
   @endcomponent
@endcomponent