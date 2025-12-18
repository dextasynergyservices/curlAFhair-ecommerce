<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Promo;

class AdminPromoNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $promo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Promo $promo)
    {
        $this->promo = $promo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.admin-promo-notification')
                    ->subject('New Promo Code Registration');
    }
}
