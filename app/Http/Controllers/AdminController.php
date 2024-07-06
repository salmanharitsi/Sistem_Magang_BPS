<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController
{
    public function get_dashboard_admin()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('admin.dashboard');
    }

    public function get_daftar_pengajuan()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('admin.daftar-pengajuan');
    }

    public function get_detail_pengajuan($id)
    {
        if (request()->pjax()) {
            return false;
        }
        
        $user = User::find($id);
        return view('admin.detail-pengajuan', compact('user'));
    }
}
