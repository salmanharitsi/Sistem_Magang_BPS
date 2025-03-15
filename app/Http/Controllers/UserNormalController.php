<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function get_magang(){
        if (request()->pjax()) {
            return false;
        }
        return view('usernormal.magang');
    }

    public function get_presensi(){
        if (request()->pjax()) {
            return false;
        }

        $magang = Auth::user()->magang()->latest()->first();

        return view('usernormal.presensi', [
            'magang' => $magang
        ]);
    }

    public function get_logbook()
    {
        if (request()->pjax()) {
            return false;
        }

        $magang = Auth::user()->magang()->latest()->first();

        return view('usernormal.logbook', [
            'magang' => $magang
        ]);
    }

    public function get_lapor_harian($id)
    {
        if (request()->pjax()) {
            return false;
        }

        $presensi = Presensi::find($id);
        if (!$presensi) {
            abort(404);
        }

        $user = auth()->user();
        $magang = $user->magang()->first(); // Mengambil satu data magang
        if (!$magang) {
            abort(404);
        }

        $presensiList = Presensi::where('magang_id', $magang->id)
            ->orderBy('tanggal', 'asc')
            ->get();
        if ($presensiList->isEmpty()) {
            abort(404);
        }

        $hariKe = $presensiList->pluck('id')->search($presensi->id);
        if ($hariKe === false) {
            abort(404);
        }

        if ($presensi->jam_masuk && $presensi->jam_keluar) {
            return redirect('/presensi');
        } 
        
        if ($presensi->status === 'izin') {
            return redirect('/presensi');
        }

        // Cek route yang dipanggil
        $routeName = request()->route()->getName();
        
        // Tambahkan validasi lokasi jika route adalah 'lapor-harian'
        if ($routeName === 'usernormal.lapor-harian') {
            // Ambil lokasi user dari request (perlu ditambahkan di form)
            $userLocation = request()->input('location');
            
            // Jika lokasi tidak tersedia dalam request, gunakan session (jika tersimpan)
            if (!$userLocation && session()->has('user_location')) {
                $userLocation = session('user_location');
            }
            
            // Jika lokasi tersedia, validasi jarak
            if ($userLocation) {
                list($userLat, $userLng) = explode(',', $userLocation);
                
                // // Koordinat kantor
                // $officeLat = 0.51001435;
                // $officeLng = 101.45457153;
                // Koordinat rumah
                $officeLat = 0.444011;
                $officeLng = 101.459271;
                // Koordinat nyasar
                // $officeLat = 0.445742;
                // $officeLng = 101.466078;
                
                $officeRadius = 50; // dalam meter
                
                // Hitung jarak menggunakan Haversine formula
                $distance = $this->calculateDistance($userLat, $userLng, $officeLat, $officeLng);
                
                // Jika user di luar radius kantor, redirect ke presensi
                if ($distance > $officeRadius) {
                    return redirect('/presensi')->with([
                        'error' => [
                            'title' => 'Kamu tidak di dalam radius kantor',
                        ]
                    ]);
                }
            } else {
                // Jika lokasi tidak tersedia sama sekali, redirect dengan pesan
                return redirect('/presensi')->with([
                    'error' => [
                        'title' => 'Lokasi tidak tersedia, silahkan coba lagi',
                    ]
                ]);
            }
        }

        // Tentukan view yang digunakan berdasarkan route
        $view = ($routeName === 'usernormal.lapor-izin') ? 'usernormal.lapor-izin' : 'usernormal.lapor-harian';

        return view($view, [
            'presensi' => $presensi,
            'hariKe' => $hariKe + 1, // Karena index dimulai dari 0, tambahkan 1
        ]);
    }

    /**
     * Menghitung jarak antara dua koordinat menggunakan Haversine formula
     * 
     * @param float $lat1 Latitude lokasi pertama
     * @param float $lng1 Longitude lokasi pertama
     * @param float $lat2 Latitude lokasi kedua
     * @param float $lng2 Longitude lokasi kedua
     * @return float Jarak dalam meter
     */
    private function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371000; // Radius bumi dalam meter
        
        $lat1Rad = deg2rad($lat1);
        $lng1Rad = deg2rad($lng1);
        $lat2Rad = deg2rad($lat2);
        $lng2Rad = deg2rad($lng2);
        
        $latDelta = $lat2Rad - $lat1Rad;
        $lngDelta = $lng2Rad - $lng1Rad;
        
        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($lat1Rad) * cos($lat2Rad) *
            sin($lngDelta / 2) * sin($lngDelta / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        return $earthRadius * $c; // Jarak dalam meter
    }

    public function get_upload_surat_pengantar_page()
    {
        if (request()->pjax()) {
            return false;
        }
        $user = Auth::user();

        $pengajuan = Pengajuan::where('user_id', $user->id)
            ->where('status_pengajuan', 'accept-first')
            ->where('surat_pengantar', null)
            ->first();

        if (!$pengajuan) {
            return redirect('/dashboard')->withErrors([
                'error' => "Pengajuan not found or is not in 'accept-first' status."
            ]);
        }

        return view('usernormal.surat-pengantar');
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
        $user = Auth::user();

        if ($pengajuan == null) {
            abort(404);
        }

        $pengajuan->delete();

        $user->status_magang = 'tidak-aktif';
        $user->save();

        return redirect(url('/pengajuan'))->with([
            'success' => [
                "title" => "Pengajuan berhasil dihapus",
            ]
        ]);
    }

    public function pengajuan_ulang($id)
    {
        if (request()->pjax()) {
            return false;
        }

        $pengajuan = Pengajuan::find($id);
        $user = Auth::user();

        if ($pengajuan == null) {
            abort(404);
        }

        $pengajuan->status_pengajuan = "reject-final";
        $pengajuan->save();

        $user->status_magang = 'tidak-aktif';
        $user->save();

        return redirect(url('/dashboard'))->with([
            'success' => [
                "title" => "Silahkan ajukan magang kembali",
            ]
        ]);
    }

    public function submit_laporan(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'image' => 'required',
                'type' => 'required|in:kehadiran,pulang', // Pastikan hanya bisa "kehadiran" atau "pulang"
            ]);

            // Temukan data presensi berdasarkan ID
            $presensi = Presensi::findOrFail($id);

            // Simpan gambar ke storage
            $imageData = $request->image;
            $image = str_replace('data:image/png;base64,', '', $imageData);
            $image = str_replace(' ', '+', $image);
            $imageName = $request->type . '_' . uniqid() . '.png'; // Nama file dinamis
            Storage::disk('public')->put('laporan_presensi/' . $imageName, base64_decode($image));

            // Perbarui data berdasarkan tipe (kehadiran atau pulang)
            if ($request->type === 'kehadiran') {
                $presensi->update([
                    'jam_masuk' => now()->format('H:i:s'),
                    'foto_masuk' => 'laporan_presensi/' . $imageName,
                    'status' => 'hadir',
                    'updated_at' => now()
                ]);
            } elseif ($request->type === 'pulang') {
                $presensi->update([
                    'jam_keluar' => now()->format('H:i:s'),
                    'foto_keluar' => 'laporan_presensi/' . $imageName,
                    'updated_at' => now()
                ]);
            }

            // Flash message sukses
            session()->flash('success', [
                'title' => 'Data ' . ucfirst($request->type) . ' berhasil disimpan!',
            ]);

            // Return response JSON
            return response()->json([
                'redirect' => url('/presensi'),
                'success' => true,
                'message' => 'Data ' . ucfirst($request->type) . ' berhasil disimpan!',
            ]);
            
        } catch (\Exception $e) {
            // Log error
            \Log::error('Error submit ' . $request->type . ': ' . $e->getMessage());

            // Return response JSON dengan error
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan ' . $request->type . '.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
