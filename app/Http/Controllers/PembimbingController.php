<?php

namespace App\Http\Controllers;

use App\Models\Magang;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ->get();

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
}
