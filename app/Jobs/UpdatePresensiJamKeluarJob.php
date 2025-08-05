<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UpdatePresensiJamKeluarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Log job start
            Log::info('UpdatePresensiJamKeluarJob started', ['date' => now()]);

            // Get today's date
            $today = Carbon::now()->toDateString();
            Log::debug("Processing presensi for date: {$today}");

            // Find presensi records for today where jam_masuk is not null and jam_keluar is null
            $presensis = DB::table('presensi')
                ->where('tanggal', $today)
                ->whereNotNull('jam_masuk')
                ->whereNull('jam_keluar')
                ->get();

            $totalRecords = count($presensis);
            Log::info("Found {$totalRecords} records to process");

            if ($totalRecords === 0) {
                Log::info('No records found matching the criteria. Job completed.');
                return;
            }

            $successCount = 0;
            $failedCount = 0;

            // Update each record
            foreach ($presensis as $presensi) {
                try {
                    DB::table('presensi')
                        ->where('id', $presensi->id)
                        ->update([
                            'point_keluar' => 75,
                            'point' => ($presensi->point_masuk + 75) / 2,
                            // Optionally, you might want to set jam_keluar to the current time
                            // 'jam_keluar' => Carbon::now()->toTimeString()
                        ]);

                    $successCount++;
                    Log::debug("Successfully updated presensi record", ['id' => $presensi->id]);
                } catch (\Exception $e) {
                    $failedCount++;
                    Log::error("Failed to update presensi record", [
                        'id' => $presensi->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }

            // Log summary
            Log::info('UpdatePresensiJamKeluarJob completed', [
                'total_records' => $totalRecords,
                'success_count' => $successCount,
                'failed_count' => $failedCount
            ]);

        } catch (\Exception $e) {
            Log::error('UpdatePresensiJamKeluarJob failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e; // Re-throw to mark job as failed
        }
    }
}