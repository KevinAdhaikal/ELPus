<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    public function daftarBukuPage() {
        $books = Buku::all();
        return view('daftar_buku', compact(var_name: 'books'));
    }

    public function manageBukuPage() {
        $books = Buku::all(); 
        return view('admin.manage_buku', compact('books'));
    }

    public function bukuById(Request $req) {
        $book = Buku::findOrFail($req->id);
        return response()->json($book);
    }

    public function postBuku(Request $req) {
        $validator = Validator::make($req->all(), [
            'nama_buku' => 'required|string',
            'cover_buku' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'penulis' => 'required|string',
            'penerbit' => 'required|string',
            'tahun_terbit' => 'required|string',
            'stok' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->first()
            ], 403);
        }

        $temp_cover_buku = "no_cover.svg";
        if ($req->hasFile('cover_buku')) {
            $file = $req->file('cover_buku');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('cover_buku'), $filename);

            $temp_cover_buku = $filename;
        }

        $buku = Buku::create([
            'nama_buku' => $req->nama_buku,
            'cover_buku' => $temp_cover_buku,
            'penulis' => $req->penulis,
            'penerbit' => $req->penerbit,
            'tahun_terbit' => $req->tahun_terbit,
            'stok' => $req->stok
        ]);

        return response()->json($buku);
    }

    public function patchBuku(Request $req) {
        $validator = Validator::make($req->all(), [
            'id' => 'required|integer',
            'nama_buku' => 'required|string',
            'cover_buku' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'penulis' => 'required|string',
            'penerbit' => 'required|string',
            'tahun_terbit' => 'required|string',
            'stok' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->first()
            ], 403);
        }

        $buku = Buku::findOrFail($req->id);

        if ($req->hasFile('cover_buku')) {
            if ($buku->cover_buku && file_exists(public_path('cover_buku/' . $buku->cover_buku))) {
                unlink(public_path('profile_img/' . $buku->cover_buku));
            }

            $file = $req->file('cover_buku');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('cover_buku'), $filename);

            $buku->cover_buku = $filename;
        }

        $buku->nama_buku = $req->nama_buku;
        $buku->penulis = $req->penulis;
        $buku->penerbit = $req->penerbit;
        $buku->tahun_terbit = $req->tahun_terbit;
        $buku->stok = $req->stok;
        $buku->save();

        return response()->json($buku);
    }

    public function deleteBuku(Request $req) {
        $validator = Validator::make($req->all(), [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->first()
            ], 403);
        }

        $buku = Buku::findOrFail($req->id);
        $buku->delete();

        return response()->json([
            'status' => 'deleted'
        ]);
    }
}
