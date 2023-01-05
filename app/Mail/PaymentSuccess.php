<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccess extends Mailable
{
    use Queueable, SerializesModels;

    protected $invoiceLink;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoiceLink)
    {
        $this->invoiceLink = $invoiceLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $invoiceLink = $this->invoiceLink;
        return $this->markdown('email.paymentSuccess' , compact('invoiceLink'));
    }
}
