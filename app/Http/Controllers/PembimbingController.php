<?php

namespace App\Http\Controllers;

use App\Models\Magang;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PembimbingController
{
    public function get_dashboard_pembimbing()
    {
        if (request()->pjax()) {
            return false;
        }

        $bimbinganActive = Magang::where(function (Builder $builder) {
            $builder->where('pembimbing_pertama', Auth::guard('pegawai')->id())
                ->orWhere('pembimbing_kedua', Auth::guard('pegawai')->id());
        })
            ->where('status_magang', 'active')
            ->where('tanggal_mulai', '<=', now())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($magang) {
                $presensi = $magang->presensi;
                $logbook = $magang->logbook;
                
                // Hitung total hari dari tanggal mulai sampai sekarang
                $startDate = Carbon::parse($magang->tanggal_mulai);
                $endDate = Carbon::now()->startOfDay();
                $totalHariKerja = $startDate->diffInDays($endDate) + 1;

                $magang->attendance_stats = [
                    'hadir' => $presensi->where('status', 'hadir')->count(),
                    'izin' => $presensi->where('status', 'izin')->count(),
                    'tidak_hadir' => $presensi->where('status', 'tidak-hadir')->count(),
                    // Exclude waiting status
                    'total' => $presensi->whereIn('status', ['hadir', 'izin', 'tidak-hadir'])->count()
                ];

                // Logbook stats dengan perhitungan baru
                $mengisi = $logbook->where('status', 'mengisi')->count();
                $tidak_mengisi = $logbook->where('status', 'tidak-mengisi')->count();
                
                $magang->logbook_stats = [
                    'mengisi' => $mengisi,
                    'tidak_mengisi' => $tidak_mengisi,
                    'belum_mengisi' => max(0, $totalHariKerja - ($mengisi + $tidak_mengisi)),
                    'total_hari_kerja' => $totalHariKerja
                ];
                return $magang;
            });

        $allBimbinganCount = Magang::where(function (Builder $builder) {
            $builder->where('pembimbing_pertama', Auth::guard('pegawai')->id())
                ->orWhere('pembimbing_kedua', Auth::guard('pegawai')->id());
        })
            ->orderBy('created_at', 'desc')
            ->count();

        return view('pembimbing.dashboard', [
            'bimbinganActive' => $bimbinganActive,
            'allBimbinganCount' => $allBimbinganCount
        ]);
    }

    public function get_daftar_persetujuan()
    {
        if (request()->pjax()) {
            return false;
        }
        
        return view('pembimbing.daftar-persetujuan');
    }

    public function get_daftar_bimbingan()
    {
        if (request()->pjax()) {
            return false;
        }
        
        return view('pembimbing.daftar-bimbingan');
    }
}
