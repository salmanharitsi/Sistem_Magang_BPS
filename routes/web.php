<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPembimbingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KetuaTimController;
use App\Http\Controllers\PembimbingController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\UserNormalController;
use Illuminate\Support\Facades\Route;

// Route home page
Route::get('/', [HomeController::class, 'index']);

// Add name to the root route
Route::get('/', [HomeController::class, 'index'])->name('login');

// Route auth page
Route::get('/login', [AuthController::class, 'get_login_page']);
Route::get('/autentikasi', [AuthController::class, 'get_autentikasi_page']);
Route::get('/login-pegawai', [AuthController::class, 'get_login_pegawai_page']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/registrasi', [AuthController::class, 'get_registrasi_page']);
Route::get('/forgot-password', [AuthController::class, 'get_forgot_password_page']);
Route::get('/reset/{token}', [AuthController::class, 'get_reset_password_page']);

// Route OTP verification (hanya untuk verifikasi pertama kali)
Route::get('/verify-otp/{id}', [AuthController::class, 'showOTPVerification'])
    ->name('verify.otp');

Route::post('/verify-otp/{id}', [AuthController::class, 'verifyOTP'])
    ->name('verify.otp.submit');

Route::post('/resend-otp/{id}', [AuthController::class, 'resendOTP'])
    ->name('resend.otp');

// Route untuk user biasa
Route::group(['middleware' => ['usernormal', 'no-cache']], function () {
    Route::get('dashboard', [UserNormalController::class, 'get_dashboard'])->name('usernormal.dashboard');
    Route::get('dashboard/surat-pengantar', [UserNormalController::class, 'get_upload_surat_pengantar_page'])->name('usernormal.upload-surat-pengantar');
    Route::get('pengajuan', [UserNormalController::class, 'get_status_pengajuan'])->name('usernormal.pengajuan');
    Route::get('magang', [UserNormalController::class, 'get_magang'])->name('usernormal.magang');
    Route::get('presensi', [UserNormalController::class, 'get_presensi'])->name('usernormal.presensi');
    Route::get('logbook', [UserNormalController::class, 'get_logbook'])->name('usernormal.logbook');
    Route::get('profil', [HomeController::class, 'get_user_profil'])->name('usernormal.profil');
    Route::get('profil-edit', [HomeController::class, 'get_user_profil_edit'])->name('usernormal.profil-edit');
    Route::get('ubah-password', [HomeController::class, 'get_ubah_password'])->name('usernormal.ubah-password');
    Route::get('pengajuan-saya/{id}', [UserNormalController::class, 'get_pengajuan_saya'])->name('usernormal.pengajuan-saya');
    Route::get('magang-saya/{id}', [UserNormalController::class, 'get_magang_saya'])->name('usernormal.magang-saya');
    Route::get('nilai-sertifikat/{id}', [UserNormalController::class, 'get_nilai_sertifikat'])->name('usernormal.nilai-sertifikat');
    Route::delete('delete-pengajuan/{id}', [UserNormalController::class, 'delete_pengajuan'])->name('usernormal.delete-pengajuan');
    Route::post('pengajuan-ulang/{id}', [UserNormalController::class, 'pengajuan_ulang'])->name('usernormal.pengajuan-ulang');
    Route::post('ajukan-magang', [UserNormalController::class, 'ajukan_magang_lagi'])->name('usernormal.ajukan-magang');
    Route::get('presensi/lapor-harian/{id}', [UserNormalController::class, 'get_lapor_harian'])->name('usernormal.lapor-harian');
    Route::post('presensi/lapor-harian/{id}/submit', [UserNormalController::class, 'submit_laporan'])->name('usernormal.submit_laporan');
    Route::get('presensi/lapor-izin/{id}', [UserNormalController::class, 'get_lapor_harian'])->name('usernormal.lapor-izin');
    Route::get('/dashboard/lengkapi-profil', [UserNormalController::class, 'lengkapiProfil'])->name('dashboard.lengkapi-profil');
    Route::get('/dashboard/ajukan-program', [UserNormalController::class, 'ajukanProgram'])->name('dashboard.ajukan-program');
    Route::get('/dashboard/lolos-seleksi', [UserNormalController::class, 'lolosSeleksi'])->name('dashboard.lolos-seleksi');
    Route::get('/dashboard/upload-surat', [UserNormalController::class, 'uploadSurat'])->name('dashboard.upload-surat');
});

// Route untuk admin
Route::group(['middleware' => ['admin', 'no-cache']], function () {
    Route::get('dashboard-admin', [AdminController::class, 'get_dashboard_admin'])->name('admin.dashboard');
    Route::get('ubah-password-admin', [HomeController::class, 'get_ubah_password'])->name('admin.ubah-password');
    Route::get('daftar-pegawai', [AdminController::class, 'get_daftar_pegawai'])->name('admin.daftar-pegawai');
    Route::get('daftar-pengajuan', [AdminController::class, 'get_daftar_pengajuan'])->name('admin.daftar-pengajuan');
    Route::get('daftar-magang', [AdminController::class, 'get_daftar_magang'])->name('admin.daftar-magang');
    Route::get('review-logbook', [AdminController::class, 'get_review_logbook'])->name('admin.review-logbook');
    Route::get('jam-kerja', [AdminController::class, 'get_jam_kerja'])->name('admin.jam-kerja');
    Route::get('detail-pengajuan/{id}', [AdminController::class, 'get_detail_pengajuan'])->name('admin.detail-pengajuan');
    Route::post('terima-pengajuan/{id}', [AdminController::class, 'terima_pengajuan'])->name('admin.terima-pengajuan');
    Route::post('tolak-pengajuan/{id}', [AdminController::class, 'tolak_pengajuan'])->name('admin.tolak-pengajuan');
    Route::post('tolak-pengajuan-tenggat/{id}', [AdminController::class, 'tolak_pengajuan_tenggat'])->name('admin.tolak-pengajuan-tenggat');
    Route::get('edit-home', [AdminController::class, 'get_fungsi_bagian'])->name('admin.edit-home');
    Route::get('input-sertifikat/{id}', [AdminController::class, 'get_input_sertifikat'])->name('admin.input-sertifikat');
    Route::get('kelola-pembimbing', [AdminController::class, 'get_kelola_pembimbing'])->name('admin.kelola-pembimbing');
});

// Route untuk pembimbing
Route::group(['middleware' => ['pembimbing', 'no-cache']], function () {
    Route::get('dashboard-pembimbing', [PembimbingController::class, 'get_dashboard_pembimbing'])->name('pembimbing.dashboard');
    Route::get('ubah-password-pembimbing', [HomeController::class, 'get_ubah_password'])->name('pembimbing.ubah-password');
});

// Route untuk admin dan pembimbing
Route::group(['middleware' => ['admin-or-pembimbing', 'no-cache']], function () {
    Route::get('daftar-bimbingan/{id}', [AdminPembimbingController::class, 'get_bimbingan'])->name('admin-or-pembimbing.bimbingan');
    Route::get('daftar-persetujuan', [AdminPembimbingController::class, 'get_daftar_persetujuan'])->name('admin-or-pembimbing.daftar-persetujuan');
    Route::get('daftar-bimbingan', [AdminPembimbingController::class, 'get_daftar_bimbingan'])->name('admin-or-pembimbing.daftar-bimbingan');
    Route::get('penilaian/{id}', [AdminPembimbingController::class, 'get_penilaian'])->name('admin-or-pembimbing.penilaian');
    Route::get('detail-nilai/{id}', [AdminPembimbingController::class, 'get_detail_nilai'])->name('admin-or-pembimbing.detail-nilai');
});

//Route untuk pimpinan
Route::group(['middleware' => ['pimpinan', 'no-cache']], function () {
    Route::get('dashboard-pimpinan', [PimpinanController::class, 'get_dashboard_pimpinan'])->name('pimpinan.dashboard');
    Route::get('ubah-password-pimpinan', [HomeController::class, 'get_ubah_password'])->name('pimpinan.ubah-password');
    Route::get('daftar-pegawai-pimpinan', [PimpinanController::class, 'get_daftar_pegawai_pimpinan'])->name('pimpinan.daftar-pegawai');
    Route::get('daftar-magang-pimpinan', [PimpinanController::class, 'get_daftar_magang_pimpinan'])->name('pimpinan.daftar-magang');
    Route::get('daftar-pembimbing', [PimpinanController::class, 'get_daftar_pembimbing'])->name('pimpinan.kelola-pembimbing');
});

//Route untuk ketua tim
Route::group(['middleware' => ['ketua-tim', 'no-cache']], function () {
    Route::get('dashboard-ketua-tim', [KetuaTimController::class, 'get_dashboard_ketua_tim'])->name('ketuatim.dashboard');
    Route::get('ubah-password-ketua-tim', [HomeController::class, 'get_ubah_password'])->name('ketuatim.ubah-password');
    Route::get('daftar-pegawai-ketua-tim', [KetuaTimController::class, 'get_daftar_pegawai_ketua_tim'])->name('ketuatim.daftar-pegawai');
    Route::get('daftar-magang-ketua-tim', [KetuaTimController::class, 'get_daftar_magang_ketua_tim'])->name('ketuatim.daftar-magang');
    Route::get('daftar-pembimbing-ketua-tim', [KetuaTimController::class, 'get_daftar_pembimbing_ketua_tim'])->name('ketuatim.kelola-pembimbing');
});
