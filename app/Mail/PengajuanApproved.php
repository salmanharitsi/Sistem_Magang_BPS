<?php

namespace App\Mail;

use App\Models\Magang;
use App\Models\Pegawai;
use App\Models\Pengajuan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class PengajuanApproved extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $pengajuan;
    public $magang;
    public $pembimbing1;
    public $pembimbing2;

    /**
     * Create a new message instance.
     */
    public function __construct(Pengajuan $pengajuan, Magang $magang)
    {
        $this->pengajuan = $pengajuan;
        $this->magang = $magang;
        
        // Get pembimbing details
        $this->pembimbing1 = Pegawai::find($magang->pembimbing_pertama);
        $this->pembimbing2 = $magang->pembimbing_kedua ? Pegawai::find($magang->pembimbing_kedua) : null;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat! Pengajuan Magang Anda Telah Disetujui',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.pengajuan-approved',
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
