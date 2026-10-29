<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadThankYou extends Mailable
{
    use SerializesModels;

    public function __construct(public Lead $lead) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->isNewsletter()
                ? 'Thank you for subscribing to BYP Health'
                : 'Thank you for contacting BYP Health',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.lead-thank-you',
        );
    }

    public function isNewsletter(): bool
    {
        return $this->lead->type === 'newsletter';
    }
}
