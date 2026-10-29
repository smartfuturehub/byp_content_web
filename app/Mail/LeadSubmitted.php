<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadSubmitted extends Mailable
{
    use SerializesModels;

    public function __construct(public Lead $lead) {}

    public function envelope(): Envelope
    {
        $to = config('mail.lead_notification.address');
        $bcc = collect(config('mail.lead_notification.bcc', []))
            ->filter()
            ->map(fn (string $email): Address => new Address($email))
            ->all();

        $fromName = $this->lead->name ?: $this->lead->email;

        return new Envelope(
            subject: 'New contact request from '.$fromName,
            to: filled($to) ? [new Address($to)] : [],
            bcc: $bcc,
            replyTo: filled($this->lead->email)
                ? [new Address($this->lead->email, $fromName)]
                : [],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.lead-submitted',
        );
    }
}
