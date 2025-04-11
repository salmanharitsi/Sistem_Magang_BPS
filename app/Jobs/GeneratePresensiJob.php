<?php

namespace App\Jobs;

use App\Models\Magang;
use App\Models\Presensi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GeneratePresensiJob implements ShouldQueue
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
                    Presensi::insert($chunk);
                }
            });
        } catch (\Exception $e) {
            \Log::error('GeneratePresensiJob failed: ' . $e->getMessage());
            $this->fail($e);
        }
    }
}