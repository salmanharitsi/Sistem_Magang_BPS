<?php

namespace App\Jobs;

use App\Models\Presensi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdatePresensiStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            DB::transaction(function () {
                $now = Carbon::now();
                $today = $now->toDateString();

                // Skip if today is Saturday or Sunday
                if ($now->isWeekend()) {
                    return;
                }

                // Ambil semua presensi yang tanggalnya hari ini
                $presensis = Presensi::where('tanggal', $today)->get();
 
                foreach ($presensis as $presensi) {

                    // Kondisi 1: Jika sudah lewat jam 5 sore dan jam_masuk == null
                    if ($now->gt(Carbon::parse($today . ' 17:00:00')) && 
                        $presensi->jam_masuk === null &&
                        $presensi->status !== 'izin') {
                        $presensi->status = 'tidak-hadir';
                        $presensi->point = 0;
                        $presensi->save();
                    }
                }
            });
        } catch (\Exception $e) {
            Log::error('UpdatePresensiStatusJob failed: ' . $e->getMessage());
            $this->fail($e);
        }
    }
}