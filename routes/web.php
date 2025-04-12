<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;


/*-----------------------------LOGIN ROUTE----------------------------------------------------------*/
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::middleware('auth')->get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
/*-----------------------------LOGIN ROUTE----------------------------------------------------------*/
