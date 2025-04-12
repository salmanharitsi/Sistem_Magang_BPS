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
use Alkoumi\LaravelHijriDate\Hijri;

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
                    // Cek apakah tanggal tersebut berada di bulan Ramadhan
                    $isRamadhan = $this->isRamadhan($tanggalMulai);
                    
                    $data[] = [
                        'id' => Str::uuid(),
                        'magang_id' => $magang->id,
                        'tanggal' => $tanggalMulai->toDateString(),
                        'aturan_jam_masuk' => $isRamadhan ? '08:00:00' : '07:00:00',
                        'aturan_jam_keluar' => $isRamadhan ? '15:00:00' : '16:00:00',
                        'status' => 'waiting',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
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

    /**
     * Cek apakah tanggal tertentu berada di bulan Ramadhan
     */
    protected function isRamadhan(Carbon $date): bool
    {
        // Konversi ke tanggal Hijriyah
        $hijriDate = Hijri::Date('Y-m-d', $date->format('Y-m-d'));
        
        // Ekstrak bulan dari tanggal Hijriyah (bulan 9 adalah Ramadhan)
        $hijriMonth = (int) substr($hijriDate, 5, 2);
        
        return $hijriMonth === 9;
    }
}