<?php

namespace App\Jobs;

use Log;
use Carbon\Carbon;
use App\Models\Magang;
use App\Models\Logbook;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateLogbookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $magang;

    /**
     * Create a new job instance.
     */
    public function __construct(Magang $magang)
    {
        $this->magang = $magang;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            DB::transaction(function () {
                $magang = Magang::find($this->magang->id);

                // Pastikan magang masih ada
                if (!$magang) {
                    return;
                }

                $tanggalMulai = Carbon::parse($magang->tanggal_mulai);
                $tanggalSelesai = Carbon::parse($magang->tanggal_selesai);

                $data = [];
                while ($tanggalMulai->lte($tanggalSelesai)) {
                    if ($tanggalMulai->isWeekday()) {
                        $data[] = [
                            'id' => Str::uuid(),
                            'magang_id' => $magang->id,
                            'tanggal' => $tanggalMulai->toDateString(),
                            'status' => 'waiting',
                        ];
                    }
                    $tanggalMulai->addDay();
                }

                // Insert data dalam batch dengan chunking
                $chunks = array_chunk($data, 100); // Proses 100 data per chunk
                foreach ($chunks as $chunk) {
                    Logbook::insert($chunk);
                }
            });
        } catch (\Exception $e) {
            \Log::error('GenerateLogbookJob failed: ' . $e->getMessage());
            $this->fail($e);
        }
    }
}
