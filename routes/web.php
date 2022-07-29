<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, AccountController, AdminController, BookingController, CashflowController, CategoryController, UserController, VehicleController};

Auth::routes(['verify' => true]); 

Route::get('/', [HomeController::class, 'index'])->name('/'); 

Route::middleware('guest')->group(function(){ 
    Route::view('/recovery', 'welcome')->name('recovery');
    Route::view('/verification', 'welcome')->name('verification');
    Route::view('/alpine', 'alpine');
});

Route::middleware('auth')->group(function(){ 
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::put('/account', [AccountController::class, 'update']);
    Route::get('/account/password', [AccountController::class, 'edit_password'])->name('password.edit');
    Route::put('/account/password', [AccountController::class, 'update_password']); 
    
    Route::middleware('verified')->group(function(){
        Route::get('/booking', [BookingController::class, 'show'])->name('booking'); 
        Route::get('/booking/search', [BookingController::class, 'search'])->name('booking.search'); 
        Route::post('/booking/create', [BookingController::class, 'create'])->name('booking.create'); 
        Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
        Route::get('/booking/{code}', [BookingController::class, 'show'])->name('booking.show');
    });
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified', 'administrator']],function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings');
    Route::put('/booking', [BookingController::class, 'update'])->name('bookings.update');
    Route::get('/bookings/export', [BookingController::class, 'export'])->name('bookings.export');
    
    Route::get('/cashflows', [CashflowController::class, 'index'])->name('cashflows');
    Route::post('/cashflows', [CashflowController::class, 'store']);
    Route::get('/cashflows/export', [CashflowController::class, 'export'])->name('cashflows.export');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/category/{id}/edit', [CategoryController::class, 'update']);
    Route::post('/category/delete', [CategoryController::class, 'destroy'])->name('categories.delete'); 
    Route::get('/categories/export', [CategoryController::class, 'export'])->name('categories.export');
    
    Route::get('/users', [UserController::class, 'index'])->name('users'); 
    Route::put('/users', [UserController::class, 'update']);
    Route::get('/users/export', [UserController::class, 'export'])->name('users.export');

    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles');
    Route::post('/vehicles', [VehicleController::class, 'store']);
    Route::get('/vehicle/{id}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::put('/vehicle/{id}/edit', [VehicleController::class, 'update']);
    Route::post('/vehicle/delete', [VehicleController::class, 'destroy'])->name('vehicles.delete');
    Route::post('/vehicles/import', [VehicleController::class, 'import'])->name('vehicles.import');
    Route::get('/vehicles/export', [VehicleController::class, 'export'])->name('vehicles.export');
});
