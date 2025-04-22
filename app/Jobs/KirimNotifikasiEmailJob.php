<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class KirimNotifikasiEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $mailable;

    /**
     * Create a new job instance.
     */
    public function __construct(string $email, Mailable $mailable)
    {
        $this->email = $email;
        $this->mailable = $mailable;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            \Log::info('Mencoba mengirim email ke: ' . $this->email);
            Mail::to($this->email)->send($this->mailable);
            \Log::info('Email berhasil dikirim ke: ' . $this->email);
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email: ' . $e->getMessage());
            throw $e;
        }
    }
}
