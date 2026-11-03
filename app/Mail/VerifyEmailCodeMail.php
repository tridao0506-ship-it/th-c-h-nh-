<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmailCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $code;
    public string $verifyUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $code)
    {
        $this->user = $user;
        $this->code = $code;
        $this->verifyUrl = route('verification.verify_link', [
            'id' => $user->id,
            'hash' => sha1($user->email . $code),
        ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[ChronoLux] Mã xác nhận đăng ký tài khoản của bạn: {$this->code}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verify_email',
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
