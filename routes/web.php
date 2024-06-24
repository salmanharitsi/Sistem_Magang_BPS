<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserNormalController;
use App\Livewire\Posts;
use App\Livewire\Registration;
use Illuminate\Support\Facades\Route;

// Route home page
Route::get('/', [HomeController::class, 'index']);

// Route auth page
Route::get('/login', [AuthController::class, 'get_login_page']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/registrasi', [AuthController::class, 'get_registrasi_page']);
Route::get('/forgot-password', [AuthController::class, 'get_forgot_password_page']);
Route::get('/reset/{token}', [AuthController::class, 'get_reset_password_page']);

// Route untuk user biasa
Route::group(['middleware' => 'usernormal'], function(){
    Route::get('dashboard', [UserNormalController::class, 'get_dashboard'])->name('usernormal.dashboard');
    Route::get('pengajuan', [UserNormalController::class, 'get_status_pengajuan'])->name('usernormal.pengajuan');
    Route::get('profil', [HomeController::class, 'get_user_profil'])->name('usernormal.profil');
    Route::get('ubah-password', [HomeController::class, 'get_ubah_password'])->name('usernormal.ubah-password');
});
