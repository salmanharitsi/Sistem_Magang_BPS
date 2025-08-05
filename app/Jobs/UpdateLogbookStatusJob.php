<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Logbook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateLogbookStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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

                // Ambil hanya logbook untuk hari ini dengan status waiting/null
                $logbooks = Logbook::where('tanggal', $today)
                    ->where(function ($query) {
                        $query->whereNull('status')
                              ->orWhere('status', 'waiting');
                    })
                    ->get();

                // Jika sudah lewat jam 5 sore
                if ($now->gt(Carbon::parse($today . ' 23:50:00'))) {
                    foreach ($logbooks as $logbook) {
                        $logbook->status = 'tidak-mengisi';
                        $logbook->updated_at = now();
                        $logbook->save();
                    }
                }
            });
        } catch (\Exception $e) {
            $this->fail($e);
        }
    }
}