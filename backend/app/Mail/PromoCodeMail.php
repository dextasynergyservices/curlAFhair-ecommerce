<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PromoCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $promoCode;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($promoCode)
    {
        $this->promoCode = $promoCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your CurlAFHair Promo Code')
                    ->markdown('emails.promo-code')
                    ->with('promoCode', $this->promoCode);
    }
}
