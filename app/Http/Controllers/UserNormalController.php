<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;

class UserNormalController
{
    public function get_dashboard()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('usernormal.dashboard');
    }

    public function get_status_pengajuan()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('usernormal.pengajuan');
    }

    public function get_logbook()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('usernormal.pengisian-logbook');
    }

    public function get_pengajuan_saya($id)
    {
        if (request()->pjax()) {
            return false;
        }

        $pengajuan = Pengajuan::find($id);

        if ($pengajuan == null) {
            abort(404);
        }

        return view('usernormal.pengajuan-saya', compact('pengajuan'));
    }

    public function delete_pengajuan($id)
    {
        if (request()->pjax()) {
            return false;
        }

        $pengajuan = Pengajuan::find($id);
        
        if ($pengajuan == null) {
            abort(404);
        }
        
        $pengajuan->delete();

        return redirect(url('/pengajuan'))->with([
            'success' => [
                "title" => "Pengajuan berhasil dihapus",
            ]
        ]);
    }
}
