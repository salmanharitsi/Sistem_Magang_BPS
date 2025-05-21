<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdatePresensiJamKeluarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get today's date
        $today = Carbon::now()->toDateString();

        // Find presensi records for today where jam_masuk is not null and jam_keluar is null
        $presensis = DB::table('presensi')
            ->where('tanggal', $today)
            ->whereNotNull('jam_masuk')
            ->whereNull('jam_keluar')
            ->get();

        // Update each record
        foreach ($presensis as $presensi) {
            DB::table('presensi')
                ->where('id', $presensi->id)
                ->update([
                    'point_keluar' => 75,
                    'point' => ($presensi->point_masuk + 75) / 2,
                    // Optionally, you might want to set jam_keluar to the current time
                    // 'jam_keluar' => Carbon::now()->toTimeString()
                ]);
        }
    }
}