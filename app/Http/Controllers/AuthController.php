<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ResetPasswordCode;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {
    public function loginPage() {
        if (auth()->check()) return redirect()->route('index');
        return view('auth.login');
    }
    public function registerPage() {
        if (auth()->check()) return redirect()->route('index');
        return view('auth.register');
    }
    public function forgotPasswordPage() {
        if (auth()->check()) return redirect()->route('index');
        return view("auth.forgot_password");
    }
    
    public function login(Request $req) {
        $req->validate([
            'username_or_email' => 'required',
            'password' => 'required',
        ]);

        $username_or_email = $req->input(key: 'username_or_email');
        $password = $req->input('password');

        $fieldType = filter_var($username_or_email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $username_or_email,
            'password' => $password
        ];

        if(Auth::attempt($credentials)) {
            return redirect()->route("utama");
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
        ]);

        return redirect(to: '/login')->with('success', 'Akun berhasil dibuat! Silahkan login.');
    }

    public function requestResetCode(Request $req) {
        $data = $req->validate([
            'email' => 'required|string|email|max:255'
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user) return redirect('forgot_password')->with('error', 'Email tersebut tidak terdaftar!');

        PasswordReset::where('email', $data['email'])->delete();

        $verification_code = random_int(100000, 999999);

        PasswordReset::create([
            'email' => $data['email'],
            'ver_code' => $verification_code,
            'created_at' => now(),
        ]);

        try {
            Mail::to($user->email)->send(new ResetPasswordCode($verification_code, $user->username));
        } catch (\Exception $e) {
            Log::error("Gagal kirim email reset password ke {$user->email}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email verifikasi. Coba lagi nanti.'
            ], 500);
        }

        return redirect('forgot_password')->with('success', "Kode berhasil dikirim! Cek email dan masukkan kode reset password.")->with('code_sended', $req->email);
    }
    public function forgotPassword(Request $req) {
        $validator = Validator::make($req->all(), [
            'email' => 'required|string|email|max:255',
            'ver_code' => 'required|integer|digits:6',
            'new_pass' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        if ($validator->fails()) {
            return redirect('forgot_password')
            ->withErrors($validator)
            ->with('code_sended', $req->email);
        }

        $passwordReset = PasswordReset::where('email', $req->email)->where('ver_code', $req->ver_code)->first();

        if (!$passwordReset) {
            return redirect('forgot_password')
            ->with('error', "Kode verifikasi salah atau email tidak cocok.")->with('code_sended', $req->email);;
        }

        $expirationTime = $passwordReset->created_at->addMinutes(5);
        if (now()->greaterThan($expirationTime)) {
            $passwordReset->delete();
            return redirect('forgot_password')
            ->with('error', "Kode verifikasi sudah kedaluwarsa. Silakan minta kode baru.");
        }

        $user = User::where('email', $req->email)->first();

        if (!$user) return redirect('forgot_password')
            ->with('error', "Email tidak ditemukan.");

        $user->password = Hash::make($req->new_pass);
        $user->save();

        $passwordReset->delete();

        return redirect('login')
        ->with('success', "Password berhasil di ganti! Silahkan login.");
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
