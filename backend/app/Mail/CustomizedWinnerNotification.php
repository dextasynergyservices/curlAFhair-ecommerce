<?php

namespace App\Mail;

use App\Models\Promo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomizedWinnerNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The promo/winner instance.
     *
     * @var \App\Models\Promo
     */
    public $promo;

    /**
     * The customized email subject.
     *
     * @var string
     */
    public $subject;

    /**
     * The customized email body.
     *
     * @var string
     */
    public $body;

    /**
     * Create a new message instance.
     */
    public function __construct(Promo $promo, string $subject, string $body)
    {
        $this->promo = $promo;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.customized-winner-notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

