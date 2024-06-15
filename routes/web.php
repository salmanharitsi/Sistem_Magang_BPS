<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route home page
Route::get('/', [HomeController::class, 'index']);
