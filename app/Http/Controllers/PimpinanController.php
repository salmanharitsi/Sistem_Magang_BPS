<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Magang;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PimpinanController
{
    public function get_dashboard_pimpinan()
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
            
            // Get incoming interns stats
            $incomingInterns = Magang::whereYear('tanggal_mulai', $selectedYear)
                ->whereMonth('tanggal_mulai', $monthNumber)
                ->get();
            
            // Get outgoing interns stats
            $outgoingInterns = Magang::whereYear('tanggal_selesai', $selectedYear)
                ->whereMonth('tanggal_selesai', $monthNumber)
                ->get();
            
            // Count by department for incoming interns
            $incomingByDept = [];
            foreach ($incomingInterns as $intern) {
                $dept = $intern->bidang_tujuan ?? 'Tidak ditentukan';
                if (!isset($incomingByDept[$dept])) {
                    $incomingByDept[$dept] = 0;
                }
                $incomingByDept[$dept]++;
            }
            
            // Count by department for outgoing interns
            $outgoingByDept = [];
            foreach ($outgoingInterns as $intern) {
                $dept = $intern->bidang_tujuan ?? 'Tidak ditentukan';
                if (!isset($outgoingByDept[$dept])) {
                    $outgoingByDept[$dept] = 0;
                }
                $outgoingByDept[$dept]++;
            }
            
            // Sort departments by count (descending)
            arsort($incomingByDept);
            arsort($outgoingByDept);
            
            $monthlyStats[] = [
                'month' => $month,
                'in' => $incomingInterns->count(),
                'out' => $outgoingInterns->count(),
                'departmentStats' => [
                    'in' => $incomingByDept,
                    'out' => $outgoingByDept
                ]
            ];
        }

        $reviewPengajuan = Pengajuan::where('status_pengajuan', 'waiting')->orWhere('status_pengajuan', 'accept-first')->count();

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


        return view('pimpinan.dashboard', compact(
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

    public function get_daftar_pegawai()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('pimpinan.daftar-pegawai');
    }

    public function get_daftar_magang()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('pimpinan.daftar-magang');
    }
}
