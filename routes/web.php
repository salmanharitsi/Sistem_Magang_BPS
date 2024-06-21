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
Route::get('/registrasi', [AuthController::class, 'get_registrasi_page']);

// Route untuk user biasa
Route::group(['middleware' => 'usernormal'], function(){
    Route::get('dashboard', [UserNormalController::class, 'get_dashboard']);
});
