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
        if (Carbon::now()->startOfDay()->gte($this->pengajuan->tanggal_mulai) 
            && ($this->pengajuan->status_pengajuan != 'reject-admin'
            || $this->pengajuan->status_pengajuan != 'reject-time'
            || $this->pengajuan->status_pengajuan != 'reject-final'
            || $this->pengajuan->status_pengajuan != 'accept-final')) {
            $this->pengajuan->status_pengajuan = 'reject-days';
            $this->pengajuan->tenggat = null;
            $this->pengajuan->save();
        }
    }
}
