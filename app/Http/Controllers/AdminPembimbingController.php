<?php

namespace App\Http\Controllers;

use App\Models\Magang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPembimbingController
{
    /**
     * Get authenticated user and determine layout
     * 
     * @return array ['user' => mixed, 'layout' => string]
     */
    private function getAuthData()
    {
        $user = Auth::guard('pegawai')->user();
        
        if (!$user || !in_array($user->role_temp, ['admin', 'regular'])) {
            abort(403, 'Unauthorized access');
        }

        $layout = ($user->role_temp === 'admin') ? 'layouts.admin' : 'layouts.pembimbing';
        
        return compact('user', 'layout');
    }

    public function get_bimbingan($id)
    {
        if (request()->pjax()) {
            return false;
        }
        
        $authData = $this->getAuthData();
        
        $magang = Magang::findOrFail($id);

        $pegawaiId = Auth::guard('pegawai')->id();

        $isPembimbing = ($magang->pembimbing_pertama == $pegawaiId) || 
                        ($magang->pembimbing_kedua == $pegawaiId);

        return view('admin-or-pembimbing.bimbingan', [
            'magang' => $magang,
            'layout' => $authData['layout'],
            'isPembimbing' => $isPembimbing
        ]);
    }

    public function get_daftar_persetujuan()
    {
        if (request()->pjax()) {
            return false;
        }

        $authData = $this->getAuthData();

        return view('admin-or-pembimbing.daftar-persetujuan', [
            'layout' => $authData['layout']
        ]);
    }

    public function get_daftar_bimbingan()
    {
        if (request()->pjax()) {
            return false;
        }

        $authData = $this->getAuthData();
        
        return view('admin-or-pembimbing.daftar-bimbingan', [
            'layout' => $authData['layout']
        ]);
    }

    public function get_detail_nilai($id)
    {
        if (request()->pjax()) {
            return false;
        }

        $magang = Magang::findOrFail($id);

        $authData = $this->getAuthData();

        if (!$magang->nilai_magang) {
            return redirect()->back();
        }
        
        return view('admin-or-pembimbing.detail-nilai', [
            'layout' => $authData['layout'],
            'magang' => $magang
        ]);
    }

    public function get_penilaian($id)
    {
        if (request()->pjax()) {
            return false;
        }
        
        $authData = $this->getAuthData();
        
        $magang = Magang::findOrFail($id);

        $pegawaiId = Auth::guard('pegawai')->id();

        $isPembimbing = ($magang->pembimbing_pertama == $pegawaiId) || 
                        ($magang->pembimbing_kedua == $pegawaiId);
        
        $checkAccPresensi = $magang->presensi()
            ->whereNull('pembimbing_id')
            ->whereRaw('DAYOFWEEK(tanggal) NOT IN (1, 7)')
            ->exists();
        
        $checkAccLogbook = $magang->logbook()
            ->whereNull('pembimbing_id')
            ->whereRaw('DAYOFWEEK(tanggal) NOT IN (1, 7)')
            ->exists();

        if (!$isPembimbing || Carbon::parse($magang->tanggal_selesai)->addDays()->isFuture() || $magang->nilai_magang) {
            return redirect()->back();
        }

        return view('admin-or-pembimbing.penilaian', [
            'magang' => $magang,
            'layout' => $authData['layout'],
            'checkAccPresensi' => $checkAccPresensi,
            'checkAccLogbook' => $checkAccLogbook
        ]);
    }
}