<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RPController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; # this is for Auth Controller

Route::get('/', function () {
    if (auth()->check()) return redirect()->route('dashboard');
    return redirect()->route('login');
});

// login routes
Route::get('/login',[AuthController::class,'loginPage'])->name('login');
Route::post('/login',[AuthController::class,'login'])->name('login');

// register routes
Route::get('/register',[AuthController::class,'registerPage'])->name('register');
Route::post('/register',[AuthController::class,'register'])->name('register');

// forgot password routes
Route::get('/forgot_password',[AuthController::class,'forgotPasswordPage'])->name('forgot_password');
Route::post('/forgot_password',[AuthController::class,'forgotPassword'])->name('forgot_password');

// logout routes
Route::get('/logout',[AuthController::class,'logout'])->name('logout');

// dashboard routes
Route::get('/dashboard',[DashboardController::class,'dashboardPage'])->name('dashboard');

// profile routes
Route::get('/profile',[ProfileController::class,'profilePage'])->name('profile');
Route::post('/profile', [ProfileController::class, 'profile'])->name('profile');

Route::post('/change_password', [ProfileController::class, 'change_password'])->name('change_password');

// admin users
Route::get('/admin/users',[UsersController::class,'usersPage'])->name('admin.users');

// admin role and permission
Route::get('/admin/rp',[RPController::class,'rpPage'])->name('admin.rp');