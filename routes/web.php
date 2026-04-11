<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RPController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Request Reset Code routes
Route::post('/req_reset_code', [AuthController::class, 'requestResetCode'])->name('req_reset_code');

// logout routes
Route::get('/logout',[AuthController::class,'logout'])->name('logout')->middleware('auth');

// dashboard routes
Route::get('/dashboard',[DashboardController::class,'dashboardPage'])->name('dashboard')->middleware('auth');

// profile routes
Route::get('/profile',[ProfileController::class,'profilePage'])->name('profile')->middleware('auth');
Route::post('/profile', [ProfileController::class, 'profile'])->name('profile')->middleware('auth');

// change password routes
Route::post('/change_password', [ProfileController::class, 'change_password'])->name('change_password')->middleware('auth');

// admin users
Route::get('/admin/users',[UsersController::class,'usersPage'])->name('admin.users')->middleware('auth');
Route::get('/admin/user_by_id', [UsersController::class, 'userById'])->name('admin.user_by_id')->middleware('auth');
Route::post('/admin/user', [UsersController::class, 'userCreate'])->name('admin.user')->middleware('auth');
Route::patch('/admin/user', [UsersController::class, 'userPatch'])->name('admin.user')->middleware('auth');
Route::delete('/admin/user', [UsersController::class, 'userDelete'])->name('admin.user')->middleware('auth');

// admin role and permission
Route::get('/admin/rp',[RPController::class,'rpPage'])->name('admin.rp')->middleware('auth');
Route::get('/admin/rp_by_id', [RPController::class, 'rpById'])->name('admin.rp_by_id')->middleware('auth');
Route::post('/admin/rp', [RPController::class, 'rpCreate'])->name('admin.rp')->middleware('auth');
Route::patch('/admin/rp', [RPController::class, 'rpPatch'])->name('admin.rp')->middleware('auth');
Route::delete('/admin/rp', [RPController::class, 'rpDelete'])->name('admin.rp')->middleware('auth');