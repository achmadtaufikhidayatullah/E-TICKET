@component('mail::message')
   <h1>Payment Successful</h1>
   <p>Thank you for making a payment, please check the invoice on your dashboard or click the link below.</p>

   @component('mail::button', ['url' => $invoiceLink])
      Your Invoice
   @endcomponent
@endcomponent