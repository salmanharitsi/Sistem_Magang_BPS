<?php

namespace App\Jobs;

use App\Models\Pengajuan; // Pastikan untuk mengimpor model Pengajuan
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use function PHPUnit\Framework\isNull;

class UpdatePengajuanStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pengajuan;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Pengajuan $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         // Ambil data pengajuan terbaru dari database
         $pengajuan = Pengajuan::find($this->pengajuan->id);

        if ($pengajuan->status_pengajuan === 'accept-final') {
            return;
        }

        // Cek apakah tenggat waktu telah berlalu
        if (!is_null($pengajuan->tenggat) && $pengajuan->tenggat <= Carbon::now()) {
            $pengajuan->status_pengajuan = 'reject-time';
            $pengajuan->komentar = 'Kamu melewati tenggat waktu upload surat pengantar!';
            $pengajuan->tenggat = null;
            $pengajuan->save();
        }
    }
}
