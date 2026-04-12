<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profilePage() {
        return view('profile');
    }
    
    public function profile(Request $req) {
        $user = Auth::user();

        $req->validate([
            'full_name' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'profile_img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($req->delete_photo == "1") {
            if ($user->profile_img && file_exists(public_path('profile_img/' . $user->profile_img))) {
                unlink(public_path('profile_img/' . $user->profile_img));
            }
            $user->profile_img = "default.svg";
        }

        if ($req->hasFile('profile_img')) {
            if ($user->profile_img && file_exists(public_path('profile_img/' . $user->profile_img))) {
                unlink(public_path('profile_img/' . $user->profile_img));
            }

            $file = $req->file('profile_img');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('profile_img'), $filename);

            $user->profile_img = $filename;
        }

        $user->full_name = $req->full_name;
        $user->username = $req->username;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile berhasil diupdate!');
    }

    public function change_password(Request $req) {
        $user = Auth::user();

        $req->validate([
            'current_pass' => 'required',
            'new_pass' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($req->current_pass, $user->password)) {
            return redirect()->route('profile')->withErrors([
                'current_pass' => 'Password lama salah.'
            ]);
        }

        $user->password = Hash::make($req->new_pass);
        $user->save();

        return redirect()->route('profile')->with('success', 'Password berhasil diubah!');
    }
}
