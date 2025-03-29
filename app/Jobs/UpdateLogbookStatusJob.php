<?php

namespace App\Jobs;

use Log;
use Carbon\Carbon;
use App\Models\Logbook;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateLogbookStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $today = Carbon::today()->toDateString();
        $cutoffTime = Carbon::today()->setHour(17)->setMinute(0)->setSecond(0);

        Log::info('UpdateLogbookStatusJob started', [
            'today' => $today,
            'cutoff_time' => $cutoffTime
        ]);

        $updatedCount = Logbook::where(function ($query) use ($today, $cutoffTime) {
            $query->where('tanggal', '<', $today)
                ->orWhere(function ($q) use ($today, $cutoffTime) {
                    $q->where('tanggal', $today)
                        ->where('created_at', '<', $cutoffTime);
                });
        })
        ->where(function ($query) {
            $query->whereNull('status')
                ->orWhere('status', '')
                ->orWhere('status', 'waiting')
                ->orWhere('status', 'mengisi');
        })
        ->update([
            'status' => 'tidak-mengisi',
            'updated_at' => now()
        ]);

        Log::info('UpdateLogbookStatusJob completed', [
            'updated_records' => $updatedCount
        ]);
    }
}