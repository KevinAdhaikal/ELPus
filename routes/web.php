<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RPController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    if (auth()->check()) return redirect()->route('daftar_buku');
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

// daftar buku routes
Route::get('/daftar_buku',[BukuController::class,'daftarBukuPage'])->name('daftar_buku')->middleware('auth');

// list peminjaman routes
Route::get('/list_peminjaman', [PeminjamanController::class, 'listPeminjamanPage'])->name('list_peminjaman')->middleware('auth');

// profile routes
Route::get('/profile',[ProfileController::class,'profilePage'])->name('profile')->middleware('auth');
Route::post('/profile', [ProfileController::class, 'profile'])->name('profile')->middleware('auth');

// change password routes
Route::post('/change_password', [ProfileController::class, 'change_password'])->name('change_password')->middleware('auth');

// buku routes
Route::get('/buku_by_id', [BukuController::class, 'bukuById'])->name('buku_by_id')->middleware('auth');

// manage buku routes
Route::get('/admin/manage_buku', [BukuController::class, 'manageBukuPage'])->name('admin.manage_buku')->middleware('auth');
Route::post('/admin/manage_buku', [BukuController::class, 'postBuku'])->name('admin.manage_buku')->middleware('auth');
Route::patch('/admin/manage_buku', [BukuController::class, 'patchBuku'])->name('admin.manage_buku')->middleware('auth');
Route::delete('/admin/manage_buku', [BukuController::class, 'deleteBuku'])->name('admin.manage_buku')->middleware('auth');

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