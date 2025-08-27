<?php

namespace App\Mail;

use App\Models\Institusi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifInstitusiAdmin extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $institusi;

    /**
     * Create a new message instance.
     */
    public function __construct(Institusi $institusi)
    {
        $this->institusi = $institusi;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendaftaran Institusi Baru - ' . $this->institusi->nama,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.notif-institusi-admin',
            with: [
                'namaInstitusi' => $this->institusi->nama,
                'alamatInstitusi' => $this->institusi->alamat,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}