<?php

namespace App\Jobs;

use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        // Ambil data pengajuan terbaru dari database
        $pengajuan = Pengajuan::find($this->pengajuan->id);

        // Pastikan pengajuan masih ada
        if (!$pengajuan) {
            return;
        }

        // Cek apakah tanggal mulai sudah lewat atau sama dengan hari ini
        if (
            Carbon::now()->startOfDay()->gte($pengajuan->tanggal_mulai)
            && !in_array($pengajuan->status_pengajuan, ['reject-admin', 'reject-time', 'reject-final', 'accept-final'])
        ) {

            $pengajuan->status_pengajuan = 'reject-days';
            $pengajuan->tenggat = null;
            $pengajuan->save();
        }
    }
}
