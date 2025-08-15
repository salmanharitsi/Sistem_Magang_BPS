<?php

namespace App\Http\ViewComposers;

use Carbon\Carbon;
use App\Models\Logbook;
use App\Models\Pengajuan;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BadgeComposer
{
    public function compose(View $view)
    {
        $userId = Auth::guard('pegawai')->user()->id;

        // Count pengajuan untuk admin
        $countPengajuan = Pengajuan::where('status_pengajuan', 'waiting')
            ->orWhere('status_pengajuan', 'accept-first')
            ->count();

        // Count persetujuan presensi
        $countPersetujuanPresensi = Presensi::with('magang')
            ->whereHas('magang', function ($query) use ($userId) {
                $query->where('pembimbing_pertama', $userId)
                    ->orWhere('pembimbing_kedua', $userId);
            })
            ->where('status_review', 'waiting')
            ->where('point', '!=', 0)
            ->where('tanggal', '<=', Carbon::today())
            ->orderBy('updated_at', 'desc')
            ->count();

        // Count persetujuan logbook
        $countPersetujuanLogbook = Logbook::with('magang')
            ->whereHas('magang', function ($query) use ($userId) {
                $query->where('pembimbing_pertama', $userId)
                    ->orWhere('pembimbing_kedua', $userId);
            })
            ->where('status_review', 'waiting')
            ->where('tanggal', '<=', Carbon::today())
            ->where('status', '!=', 'waiting')
            ->count();

        $countPersetujuan = $countPersetujuanPresensi + $countPersetujuanLogbook;

        $view->with([
            'countPengajuan' => $countPengajuan,
            'countPersetujuan' => $countPersetujuan
        ]);
    }
}
