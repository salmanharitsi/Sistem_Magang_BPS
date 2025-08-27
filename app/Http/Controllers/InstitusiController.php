<?php

namespace App\Http\Controllers;

use App\Models\Institusi;
use Illuminate\Http\Request;
use App\Mail\NotifInstitusiAdmin;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;

class InstitusiController extends Controller
{
    public function index()
    {
        return view('institusi.index', [
            'institusiPending'  => Institusi::where('status', 'pending')->get(),
            'institusiApproved' => Institusi::where('status', 'approved')->get(),
            'institusiRejected' => Institusi::where('status', 'rejected')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:255|unique:institusi,nama',
            'alamat' => 'required|string|max:500',
        ], [
            'nama.required'   => 'Nama institusi wajib diisi',
            'nama.unique'     => 'Nama institusi sudah terdaftar',
            'alamat.required' => 'Alamat institusi wajib diisi',
        ]);

        try {
            // Simpan institusi baru, default status = pending
            $institusi = Institusi::create([
                'nama'   => $request->nama,
                'alamat' => $request->alamat,
                'status' => 'pending',
            ]);

            // Kirim email notifikasi ke admin spesifik (sama seperti pengajuan magang)
            \Log::info('Mengirim email notifikasi institusi baru ke admin');
            
            try {
                Mail::to('fajarrahmat0127@gmail.com')->send(new NotifInstitusiAdmin($institusi));
                \Log::info('Email berhasil dikirim ke: fajarrahmat0127@gmail.com');
            } catch (\Exception $mailException) {
                \Log::error('Gagal mengirim email: ' . $mailException->getMessage());
                \Log::error('Email error trace: ' . $mailException->getTraceAsString());
            }

            // Opsional: Jika ingin mengirim ke beberapa email sekaligus
            // $adminEmails = ['fajarrahmat934@gmail.com', 'admin@bps.go.id'];
            // foreach ($adminEmails as $adminEmail) {
            //     Mail::to($adminEmail)->send(new NotifInstitusiAdmin($institusi));
            // }

            return redirect()->route('institusi.index')->with('success', [
                'title'   => 'Berhasil!',
                'message' => 'Institusi berhasil didaftarkan. Silakan tunggu proses verifikasi dari admin BPS (1-3 hari kerja).'
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email notifikasi institusi: ' . $e->getMessage());
            return redirect()->back()->with('error', [
                'title'   => 'Error!',
                'message' => 'Terjadi kesalahan saat mendaftarkan institusi. Silakan coba lagi.'
            ])->withInput();
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $institusi = Institusi::findOrFail($id);
        $institusi->update(['status' => $request->status]);

        $message = $request->status === 'approved' ? 'disetujui' : 'ditolak';

        return redirect()->back()->with('success', [
            'title'   => 'Berhasil!',
            'message' => "Status institusi berhasil diubah menjadi {$message}."
        ]);
    }
}