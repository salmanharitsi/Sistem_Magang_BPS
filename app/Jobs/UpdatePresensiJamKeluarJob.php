<?php

namespace App\Jobs;

use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdatePresensiJamKeluarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            DB::transaction(function () {
                $now = Carbon::now();
                $today = $now->toDateString();

                // Ambil semua presensi yang tanggalnya hari ini
                $presensis = Presensi::where('tanggal', $today)->get();
 
                foreach ($presensis as $presensi) {

                    // Kondisi 2: Jika jam_masuk !== null dan jam_keluar == null hingga jam 7 malam
                    if ($presensi->jam_masuk !== null && $presensi->jam_keluar === null && $now->gt(Carbon::parse($today . ' 19:00:00'))) {
                        $presensi->jam_keluar = Carbon::parse($today . ' 19:00:00');
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
