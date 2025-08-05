<?php

namespace App\Jobs;

use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdatePengajuanOverLimit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pengajuan;

    /**
     * Create a new job instance.
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
        Log::info('[JOB] Menjalankan UpdatePengajuanOverLimit untuk ID: ' . $this->pengajuan->id);

        // Ambil data pengajuan terbaru dari database
        $pengajuan = Pengajuan::find($this->pengajuan->id);

        if (!$pengajuan) {
            Log::warning('[JOB] Pengajuan ID: ' . $this->pengajuan->id . ' tidak ditemukan.');
            return;
        }

        Log::info('[JOB] Ditemukan Pengajuan ID: ' . $pengajuan->id . ', tanggal_mulai: ' . $pengajuan->tanggal_mulai . ', status: ' . $pengajuan->status_pengajuan);

        if (
            Carbon::now()->startOfDay()->gte($pengajuan->tanggal_mulai)
            && !in_array($pengajuan->status_pengajuan, ['reject-admin', 'reject-time', 'reject-final', 'accept-final'])
        ) {
            $pengajuan->status_pengajuan = 'reject-days';
            $pengajuan->tenggat = null;
            $pengajuan->save();

            Log::info('[JOB] Pengajuan ID: ' . $pengajuan->id . ' diupdate ke status "reject-days".');
        } else {
            Log::info('[JOB] Pengajuan ID: ' . $pengajuan->id . ' tidak memenuhi syarat untuk diubah.');
        }
    }
}
