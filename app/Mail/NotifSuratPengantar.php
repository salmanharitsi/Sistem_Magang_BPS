<?php

namespace App\Mail;

use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifSuratPengantar extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $pengajuan;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct(Pengajuan $pengajuan, User $user)
    {
        $this->pengajuan = $pengajuan;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Surat Pengantar Baru Diupload',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'admin.notif-surat-pengantar',
            with: [
                'userName' => $this->user->name,
                'pengajuanId' => $this->pengajuan->id,
                'originalFilename' => $this->pengajuan->original_filename_surat_pengantar,
                'uploadedAt' => now()->format('d M Y H:i:s'),
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