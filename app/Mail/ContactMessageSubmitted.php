<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $messageModel)
    {
    }

    public function build(): self
    {
        return $this->subject('New contact message from ' . $this->messageModel->name)
            ->view('emails.contact-message')
            ->with([
                'messageModel' => $this->messageModel,
            ]);
    }
}
