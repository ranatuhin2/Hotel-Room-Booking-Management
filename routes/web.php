<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\HomeController;



/*-----------------------------LOGIN ROUTE----------------------------------------------------------*/
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
/*-----------------------------LOGIN ROUTE----------------------------------------------------------*/


/*---------------------------------USER ROUTE----------------------------------------------------------*/
Route::prefix('user')->name('user.')->middleware('auth')->group(function () {

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

});



/*-----------------------------ADMIN ROUTE(ROOM)----------------------------------------------------------*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::prefix('rooms')->name('rooms.')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('index'); 
        Route::get('/load', [RoomController::class, 'loadRooms'])->name('load');              
        Route::get('/create', [RoomController::class, 'create'])->name('create');        
        Route::post('/create', [RoomController::class, 'store'])->name('store');         
        Route::get('/edit/{room}', [RoomController::class, 'edit'])->name('edit');       
        Route::put('/update/{room}', [RoomController::class, 'update'])->name('update'); 
        Route::delete('/delete/{room}', [RoomController::class, 'destroy'])->name('destroy'); 
    });


});
