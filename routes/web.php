<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\User\HomeController as UserHomeController;
use App\Http\Controllers\User\RoomBookingController;
use App\Http\Middleware\IsAdmin;




/*-----------------------------LOGIN ROUTE----------------------------------------------------------*/
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
/*-----------------------------LOGIN ROUTE----------------------------------------------------------*/


/*---------------------------------USER ROUTE----------------------------------------------------------*/
Route::prefix('user')->name('user.')->middleware('auth')->group(function () {

    Route::get('/dashboard', [UserHomeController::class, 'dashboard'])->name('dashboard');

    Route::prefix('booking')->name('booking.')->middleware(['auth'])->group(function () {
        Route::get('/rooms', [RoomBookingController::class, 'index'])->name('index');
        Route::post('/book', [RoomBookingController::class, 'book'])->name('book');
        Route::get('/my-bookings', [RoomBookingController::class, 'myBookings'])->name('myBookings');
        Route::delete('/cancel-booking/', [RoomBookingController::class, 'cancel'])->name('cancel');
        Route::get('/filter-rooms', [RoomBookingController::class, 'filter'])->name('filter');
        Route::post('/get-rooms', [RoomBookingController::class, 'getRoomData'])->name('getRoomData');
         

    });

});



/*-----------------------------ADMIN ROUTE(ROOM)----------------------------------------------------------*/
Route::prefix('admin')->name('admin.')->middleware(['auth',IsAdmin::class])->group(function () {

    Route::get('/dashboard', [AdminHomeController::class, 'dashboard'])->name('dashboard');

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
