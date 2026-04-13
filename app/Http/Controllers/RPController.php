<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'permission_level' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->first()
            ], 403);
        }

        $role = Roles::create([
            'name' => $req->name,
            'permission_level' => $req->permission_level
        ]);

        return response()->json([
            'data' => $role
        ]);
    }

    public function rpPatch(Request $req) {
        $validator = Validator::make($req->all(), [
            'id' => 'required|integer',
            'name' => 'required',
            'permission_level' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->first()
            ], 403);
        }

        $role = Roles::findOrFail($req->id);

        $role->update([
            'name' => $req->name,
            'permission_level' => $req->permission_level
        ]);

        return response()->json([
            'data' => $role
        ]);
    }

    public function rpDelete(Request $req) {
        $validator = Validator::make($req->all(), [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->first()
            ], 403);
        }

        $role = Roles::findOrFail($req->id);
        $role->delete();

        return response()->json([
            'status' => 'deleted'
        ]);
    }
}