<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifSeleksiPertama extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $status;
    public $name;
    public $komentar;

    /**
     * Create a new message instance.
     */
    public function __construct($status, $name, $komentar = null)
    {
        $this->status = $status;
        $this->name = $name;
        $this->komentar = $komentar;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->status == 'accepted' 
            ? 'Selamat! Pengajuan Magang Anda Diterima' 
            : 'Informasi Status Pengajuan Magang';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.notif-seleksi-pertama',
            with: [
                'status' => $this->status,
                'name' => $this->name,
                'komentar' => $this->komentar
            ]
        );
    }
}
