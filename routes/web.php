<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; # this is for Auth Controller

Route::get('/', function () {
    if (auth()->check()) return redirect()->route('dashboard');
    return redirect()->route('login');
});

// login routes
Route::get('/login',[AuthController::class,'loginPage'])->name('login');
Route::post('/login',[AuthController::class,'login']);

// register routes
Route::get('/register',[AuthController::class,'registerPage'])->name('register');
Route::post('/register',[AuthController::class,'register']);

// forgot password routes
Route::get('/forgot_password',[AuthController::class,'forgotPasswordPage'])->name('forgot_password');
Route::post('/forgot_password',[AuthController::class,'forgotPassword']);

// logout routes
Route::get('/logout',[AuthController::class,'logout'])->name('logout');

// dashboard routes
Route::get('/dashboard',function(){
    return view('dashboard');
})->middleware('auth')->name('dashboard');