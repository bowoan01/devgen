<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageNotification extends Mailable
{
    use Queueable, SerializesModels;

    public ContactMessage $messageModel;

    public function __construct(ContactMessage $message)
    {
        $this->messageModel = $message;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New contact message from ' . $this->messageModel->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.contact-notification',
            with: [
                'messageModel' => $this->messageModel,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
