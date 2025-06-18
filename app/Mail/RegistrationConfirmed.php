<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        if (is_string($data['display_conference']) && json_validate($data['display_conference'])) {
            $data['display_conference'] = json_decode($data['display_conference'], true);
        }
        $this->data = $data;
    }

    public function build()
    {
        $subject = 'ICCFB 2025 - Registration Confirmation - ' . ($this->data['display_title'] ?? '') . ' ' . ($this->data['fullname'] ?? '');

        return $this->subject($subject)
            ->view('emails.online-payment')
            ->with('registration', $this->data);
    }
}
