<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Magang;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;
use App\Jobs\UpdatePengajuanStatusJob;

class AdminController
{
    public function get_dashboard_admin()
    {
        if (request()->pjax()) {
            return false;
        }

        // Get years for filter
        $years = Magang::selectRaw('DISTINCT YEAR(tanggal_mulai) as year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        if ($years->isEmpty()) {
            $years = collect([Carbon::now()->year]);
        }

        // Get selected year from request, default to most recent year
        $selectedYear = request('year', 2025);

        $chartData = [];
        foreach ($years as $year) {
            $monthlyData = [];
            for ($month = 1; $month <= 12; $month++) {
                $masuk = Magang::whereYear('tanggal_mulai', $year)
                    ->whereMonth('tanggal_mulai', $month)
                    ->count();

                $keluar = Magang::whereYear('tanggal_selesai', $year)
                    ->whereMonth('tanggal_selesai', $month)
                    ->count();

                $monthlyData[] = [
                    'month' => Carbon::create()->month($month)->format('M'),
                    'masuk' => $masuk,
                    'keluar' => $keluar
                ];
            }
            $chartData[$year] = $monthlyData;
        }

        // Get monthly stats for selected year only
        $months = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'];

        $monthlyStats = [];
        foreach ($months as $index => $month) {
            $monthNumber = $index + 1;
            $starting = Magang::whereYear('tanggal_mulai', $selectedYear)
                ->whereMonth('tanggal_mulai', $monthNumber)
                ->count();
            $ending = Magang::whereYear('tanggal_selesai', $selectedYear)
                ->whereMonth('tanggal_selesai', $monthNumber)
                ->count();
            $monthlyStats[] = [
                'month' => $month,
                'in' => $starting,
                'out' => $ending
            ];
        }

        $reviewPengajuan = Pengajuan::where('status_pengajuan', 'waiting')->count();

        // Hitung total pengajuan
        $totalPengajuan = Pengajuan::count();

        // Data bulanan
        $pengajuanBulanIni = Pengajuan::whereMonth('created_at', Carbon::now()->month)->count();

        // // Hitung Total Magang
        $magangActive = Magang::where('status_magang', 'active')->count();

        // Hitung total pengajuan
        $totalMagang = Magang::count();

        // Data bulanan
        $magangBulanIni = Magang::whereMonth('created_at', Carbon::now()->month)->count();


        return view('admin.dashboard', compact(
            'monthlyStats',
            'chartData',
            'years',
            'selectedYear',
            'reviewPengajuan',
            'totalPengajuan',
            'pengajuanBulanIni',
            'totalMagang',
            'magangBulanIni',
            'magangActive'
        ));
    }

    public function get_daftar_pengajuan()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('admin.daftar-pengajuan');
    }

    public function get_daftar_magang()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('admin.daftar-magang');
    }
    
    public function get_review_logbook()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('admin.review-logbook');
    }

    public function get_detail_pengajuan($id)
    {
        if (request()->pjax()) {
            return false;
        }

        $pengajuan = Pengajuan::find($id);

        if ($pengajuan == null) {
            abort(404);
        }

        return view('admin.detail-pengajuan', compact('pengajuan'));
    }

    public function terima_pengajuan($id)
    {
        if (request()->pjax()) {
            return false;
        }

        $pengajuan = Pengajuan::find($id);

        if ($pengajuan == null) {
            abort(404);
        }

        $pengajuan->status_pengajuan = "accept-first";
        
        // Calculate tenggat based on tanggal_mulai
        $tanggalMulai = Carbon::parse($pengajuan->tanggal_mulai);
        $tenggatDefault = now()->addDays(7);
        
        // Set tenggat to either 7 days from now or tanggal_mulai, whichever comes first
        $pengajuan->tenggat = $tanggalMulai->lt($tenggatDefault) ? $tanggalMulai->copy()->subDay() : $tenggatDefault;
        $pengajuan->save();

        // Dispatch job untuk memperbarui status setelah tenggat
        UpdatePengajuanStatusJob::dispatch($pengajuan)->delay($pengajuan->tenggat);

        return redirect(url('/daftar-pengajuan'))->with([
            'success' => [
                "title" => "Berhasil menerima pengajuan",
            ]
        ]);
    }

    public function tolak_pengajuan($id)
    {
        if (request()->pjax()) {
            return false;
        }

        $pengajuan = Pengajuan::find($id);

        if ($pengajuan == null) {
            abort(404);
        }

        $pengajuan->status_pengajuan = "reject-admin";
        $komentar = request('komentar');
        $pengajuan->komentar = $komentar;
        $pengajuan->save();

        return redirect(url('/daftar-pengajuan'))->with([
            'success' => [
                "title" => "Berhasil menolak pengajuan",
            ]
        ]);
    }
}
