<?php

namespace App\Http\Controllers;

use App\Models\Magang;
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
        
        // Dapatkan data magang
        $magang = Magang::findOrFail($id);

        return view('admin-or-pembimbing.bimbingan', [
            'magang' => $magang,
            'layout' => $authData['layout']
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
}