<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;

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

        $pengajuan = Pengajuan::find($id);

        if ($pengajuan == null) {
            abort(404);
        }

        return view('admin.detail-pengajuan', compact('pengajuan'));
    }
}
