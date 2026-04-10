<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller {
    public function loginPage() {
        return view('auth.login');
    }
    public function registerPage() {
        return view('auth.register');
    }
    public function forgotPasswordPage() {
        return view("auth.forgot_password");
    }
    
    public function login(Request $req) {
        $req->validate([
            'username_or_email' => 'required',
            'password' => 'required|min:8',
        ]);

        $username_or_email = $req->input(key: 'username_or_email');
        $password = $req->input('password');

        $fieldType = filter_var($username_or_email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $username_or_email,
            'password' => $password
        ];

        if(Auth::attempt($credentials)) {
            return redirect('/dashboard');
        }

        return redirect('login')->with('error','Username / Email or Password is incorrect');
    }
    public function register(Request $req) {
        $req->validate([
            'full_name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            ], [
            'full_name.required' => 'Full Name wajib diisi.',

            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan, silakan pilih username lain.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);
        
        User::create([
            'full_name' => $req->input('full_name'),
            'username' => $req->input('username'),
            'email' => $req->input('email'),
            'password' => $req->input('password'),
        ])->save();

        return redirect(to: '/login')->with('success', 'Akun berhasil dibuat! Silahkan login.');
    }
    public function forgotPassword(Request $req) {
        return redirect('/login');
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
