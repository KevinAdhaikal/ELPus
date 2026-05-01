<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function usersPage() {
        if (!auth()->check()) return redirect()->route('login');
        if (!auth()->user()->hasPermission(Roles::ADMINISTRATOR)) return redirect()->route('index');

        $users = User::all();
        $roles = Roles::all();

        return view('admin.users', compact('users', 'roles'));
    }

    public function userById(Request $req) {
        $user = User::findOrFail($req->id);
        return response()->json($user);
    }

    public function userCreate(Request $req) {
        $validator = Validator::make($req->all(), [
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'full_name' => 'required|string|max:255',
            'role_id' => 'required|integer|exists:roles,id',
            'password' => 'nullable|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->first()
            ], 403);
        }

        $user = User::create([
            'username' => $req->username,
            'full_name' => $req->full_name,
            'email' => $req->email,
            'role_id' => $req->role_id,
            'password' => Hash::make($req->password)
        ]);

        return response()->json([
            'data' => $user
        ]);
    }

    public function userPatch(Request $req) {
        $user = User::findOrFail($req->id);

        $validator = Validator::make($req->all(), [
            'username' => 'required|string|max:255|unique:users,username,' . $user->id . ',id',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id . ',id',
            'full_name' => 'required|string|max:255',
            'role_id' => 'required|integer|exists:roles,id',
            'password' => 'nullable|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $req->only(['username', 'full_name', 'email', 'role_id']);

        if ($req->filled('password')) {
            $data['password'] = Hash::make($req->password);
        }

        $user->update($data);

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }
    
    public function userDelete(Request $req) {
        $validator = Validator::make($req->all(), [
            'id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->first()
            ], 403);
        }

        $user = User::findOrFail($req->id);
        $user->delete();

        return response()->json([
            'status' => 'deleted'
        ]);
    }
}
