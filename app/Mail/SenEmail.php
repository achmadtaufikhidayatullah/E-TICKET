<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SenEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($UserId)
    {
        $this->id = $UserId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $id = $this->id;
        return $this->markdown('email.verification' , compact('id'));
    }
}
