<?php

namespace App\Http\Controllers;

use App\Models\Magang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPembimbingController
{
    public function get_bimbingan($id)
    {
        if (request()->pjax()) {
            return false;
        }
        
        // Verifikasi autentikasi dan role
        $user = Auth::guard('pegawai')->user();
        
        if (!$user || !in_array($user->role_temp, ['admin', 'regular'])) {
            abort(403, 'Unauthorized access');
        }

        // Dapatkan data magang
        $magang = Magang::findOrFail($id);

        // Tentukan layout berdasarkan role
        $layout = ($user->role_temp === 'admin') ? 'layouts.admin' : 'layouts.pembimbing';

        return view('admin-or-pembimbing.bimbingan', [
            'magang' => $magang,
            'layout' => $layout
        ]);
    }
}