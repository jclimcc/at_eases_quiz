<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'user'])->name('dashboard');

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    //create resource route for users
    Route::resource('users', UserController::class)->names([
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'index' => 'admin.users.index',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
        'show' => 'admin.users.show',
    ]);
    Route::resource('drivers', DriverController::class)->names([
        'create' => 'admin.drivers.create',
        'store' => 'admin.drivers.store',
        'index' => 'admin.drivers.index',
        'edit' => 'admin.drivers.edit',
        'update' => 'admin.drivers.update',
        'destroy' => 'admin.drivers.destroy',
        'show' => 'admin.drivers.show',
    ]);
    Route::resource('admins', AdminController::class)->names([
        'create' => 'admin.admins.create',
        'store' => 'admin.admins.store',
        'index' => 'admin.admins.index',
        'edit' => 'admin.admins.edit',
        'update' => 'admin.admins.update',
        'destroy' => 'admin.admins.destroy',
        'show' => 'admin.admins.show',
    ]);


    Route::get('products', function () {
        return view('admin.products');
    })->name('admin.products');
    // Add more admin routes here
});

require __DIR__ . '/auth.php';
