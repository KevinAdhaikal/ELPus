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
            'login_input' => 'required',
            'password' => 'required|min:8',
        ]);

        $login_input = $req->input('login_input');
        $password = $req->input('password');

        $fieldType = filter_var($login_input, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $login_input,
            'password' => $password
        ];

        if(Auth::attempt($credentials)) {
            return redirect('/dashboard');
        }

        return back()->with('error','Username / Email or Password is incorrect');
    }
    public function register(Request $req) {
        $req->validate([
            'full_name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);
        
        User::create([
            'full_name' => $req->input('full_name'),
            'username' => $req->input('username'),
            'email' => $req->input('email'),
            'password' => $req->input('password'),
        ])->save();

        return redirect(to: '/login');
    }
    public function forgotPassword(Request $req) {
        return redirect('/login');
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
