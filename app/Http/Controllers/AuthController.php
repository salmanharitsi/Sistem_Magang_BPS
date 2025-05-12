<?php

namespace App\Http\Controllers;

use App\Jobs\OTPJob;
use App\Models\User;
use App\Models\OTP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AuthController
{
    public function get_login_page()
    {
        if (!empty(Auth::check())) {
            return redirect('dashboard');
        }
        if (!empty(Auth::guard('pegawai')->check())) {
            $pegawai = Auth::guard('pegawai')->user();
            if($pegawai->role_temp == 'regular') {
                return redirect('dashboard-pembimbing');
            }
            else if($pegawai->role_temp == 'admin') {
                return redirect('dashboard-admin');
            }
        }
        return view('auth.login');
    }

    public function get_autentikasi_page(User $user)
    {
        if (!empty(Auth::check())) {
            return redirect('dashboard');
        }
        return view('auth.autentikasiOTP', compact('user'));
    }



    public function get_login_pegawai_page()
    {
        if (!empty(Auth::guard('pegawai')->check())) {
            $pegawai = Auth::guard('pegawai')->user();
            if($pegawai->role_temp == 'regular') {
                return redirect('dashboard-pembimbing');
            }
            else if($pegawai->role_temp == 'admin') {
                return redirect('dashboard-admin');
            }
        }
        if (!empty(Auth::check())) {
            return redirect('dashboard');
        }
        return view('auth.login_pegawai');
    }

    public function get_registrasi_page(){
        if (!empty(Auth::check())) {
            return redirect('dashboard');
        }
        return view('auth.registrasi');
    }

    public function get_forgot_password_page(){
        if (!empty(Auth::check())) {
            return redirect('dashboard');
        }
        return view('auth.forgotPassword');
    }

    public function get_reset_password_page(Request $request, $token){
        if (!empty(Auth::check())) {
            return redirect('dashboard');
        }

        $user = User::where('remember_token', '=', $token);
        if ($user->count() == 0) {
            abort(403);
        }
        $user = $user->first();
        $data['token'] = $token;

        return view('auth.resetPassword', $data);
    }

    public function logout()
    {
        if (Auth::guard('pegawai')->check()) {
            Auth::guard('pegawai')->logout();
            return redirect(url('/'))->with([
                'success' => [
                    "title" => "Berhasil keluar",
                ]
            ]);
        }

        if (Auth::check()) {
            Auth::logout();
            return redirect(url('/'))->with([
                'success' => [
                    "title" => "Berhasil keluar",
                ]
            ]);
        }
    }

    //auth punya
    public function showOTPVerification($id) // Ubah dari $uid ke $id
    {
        try {
            $otp = OTP::where('id', $id) // Ubah dari uid ke id
                ->where('verified', false)
                ->latest()
                ->first();

            if (!$otp) {
                return redirect('/')->with([
                    'error' => [
                        'title' => 'OTP tidak ditemukan',
                        'message' => 'Silahkan lakukan registrasi terlebih dahulu'
                    ]
                ]);
            }

            return view('auth.autentikasiOTP', ['id' => $id, 'email' => $otp->email]);
        } catch (\Exception $e) {
            return redirect('/')->with([
                'error' => [
                    'title' => 'Terjadi kesalahan',
                    'message' => $e->getMessage()
                ]
            ]);
        }
    }

    public function verifyOTP(Request $request, $id) // Ubah dari $uid ke $id
    {
        try {
            $request->validate([
                'otp' => 'required|string:6'
            ]);

            $submittedOTP = $request->input('otp');

            // Debug log
            \Log::info('Input OTP:', [
                'submitted_otp' => $submittedOTP
            ]);

            $otp = OTP::where('id', $id) // Ubah dari uid ke id
                ->where('verified', false)
                ->latest()
                ->first();

            if (!$otp) {
                throw new \Exception('OTP tidak ditemukan atau sudah tidak valid');
            }

            // Debug log
            \Log::info('OTP Comparison:', [
                'stored_otp' => $otp->otp_code,
                'submitted_otp' => $submittedOTP
            ]);

            if ($otp->otp_code !== $submittedOTP) {
                return back()->with([
                    'error' => [
                        "title" => "Kode OTP tidak valid",
                        "message" => "Pastikan kode yang Anda masukkan benar"
                    ]
                ]);
            }

            DB::transaction(function () use ($otp) {
                // Create user from stored registration data
                $userData = $otp->registration_data;

                // Create user instance first
                $user = new User();

                // Set attributes manually
                $user->name = $userData['name'];
                $user->email = $otp->email;
                $user->nomor_induk = $userData['nomor_induk'];
                $user->institusi = $userData['institusi'];
                $user->jurusan = $userData['jurusan'];
                $user->kartu_tanda = $userData['kartu_tanda'];
                $user->original_filename_kartu = $userData['original_filename_kartu'];
                $user->nomor_hp = $userData['nomor_hp'];
                $user->password = $userData['password'];
                $user->email_verified_at = now();

                // Save the user
                $user->save();

                // Mark OTP as verified
                $otp->update(['verified' => true]);

                // Move image if exists
                if (isset($userData['kartu_tanda']) && Storage::exists('public/temp/' . $userData['kartu_tanda'])) {
                    Storage::move(
                        'public/temp/' . $userData['kartu_tanda'],
                        'public/' . $userData['kartu_tanda']
                    );
                }

                // Login user
                Auth::login($user);
            });

            return redirect('/dashboard')->with([
                'success' => [
                    "title" => "Registrasi Berhasil",
                    "message" => "Selamat datang di Sistem Magang BPS"
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('OTP Verification Error: ' . $e->getMessage());
            return back()->with([
                'error' => [
                    "title" => "Gagal verifikasi OTP",
                    "message" => $e->getMessage()
                ]
            ]);
        }
    }

    public function resendOTP($id)
    {
        try {
            $lastOTP = OTP::where('id', $id)
                ->latest()
                ->first();

            $newOTPRecord = null; // Define variable outside transaction

            DB::transaction(function () use ($lastOTP, &$newOTPRecord) {
                if ($lastOTP) {
                    $lastOTP->update(['verified' => true]);
                }

                $newOTP = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

                // Create new OTP and store the record
                $newOTPRecord = OTP::create([
                    'email' => $lastOTP->email,
                    'otp_code' => $newOTP,
                    'verified' => false,
                    'resend_time' => now(),
                    'registration_data' => $lastOTP->registration_data ?? null
                ]);

                OTPJob::dispatch($lastOTP->email, $newOTP, $newOTPRecord->id);

            });

            // Redirect to new OTP verification page with new ID
            return redirect("/verify-otp/{$newOTPRecord->id}")->with([
                'success' => [
                    "title" => "OTP baru telah dikirim ke email Anda!"
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('OTP Resend Error: ' . $e->getMessage());
            return redirect("/verify-otp/{$id}")->with([
                'error' => [
                    "title" => "Gagal mengirim OTP baru"
                ]
            ]);
        }
    }
}
