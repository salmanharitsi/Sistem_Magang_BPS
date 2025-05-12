<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Pengajuan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifPengajuanAdmin extends Mailable implements ShouldQueue
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
            subject: 'Baru! Pengajuan Magang Masuk',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.notif-pengajuan-magang',
            with: [
                'userName' => $this->user->name,
                'userEmail' => $this->user->email,
                'jensMagang' => $this->pengajuan->jenis_magang,
                'bidangTujuan' => $this->pengajuan->bidang_tujuan,
                'tanggalMulai' => $this->pengajuan->tanggal_mulai,
                'tanggalSelesai' => $this->pengajuan->tanggal_selesai,
                'pengajuanId' => $this->pengajuan->id,
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
