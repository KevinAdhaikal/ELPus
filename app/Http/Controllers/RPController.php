<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;

class RPController extends Controller
{
    public function rpPage() {
        $roles = Roles::all();
        return view('admin.rp', compact('roles'));
    }

    public function rpById(Request $req) {
        $role = Roles::findOrFail($req->id);
        return response()->json($role);
    }

    public function rpCreate(Request $req) {
        $role = Roles::create([
            'name' => $req->name,
            'permission_level' => $req->perm
        ]);

        return response()->json([
            'data' => $role
        ]);
    }

    public function rpPatch(Request $req) {
        $role = Roles::findOrFail($req->id);

        $role->update([
            'name' => $req->name,
            'permission_level' => $req->perm
        ]);

        return response()->json([
            'data' => $role
        ]);
    }

    public function rpDelete(Request $req) {
        $role = Roles::findOrFail($req->id);
        $role->delete();

        return response()->json([
            'status' => 'deleted'
        ]);
    }
}