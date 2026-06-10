<?php

namespace App\Mail;

use App\Models\SiteSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailSubject;
    public $emailContent;
    public $unsubscribeUrl;
    public $siteSettings;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $content, $subscriberEmail)
    {
        $this->emailSubject = $subject;
        $this->emailContent = $content;
        $this->unsubscribeUrl = route('newsletter.unsubscribe', ['email' => base64_encode($subscriberEmail)]);
        $this->siteSettings = SiteSetting::first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter',
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
