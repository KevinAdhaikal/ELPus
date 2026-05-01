<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    public function listPeminjamanPage() {
        if (!auth()->check()) return redirect()->route('login');
        if (!auth()->user()->hasPermission(Roles::PINJAM_LIHAT_SENDIRI | Roles::ADMINISTRATOR)) return redirect()->route('index');
        
        $pinjamans = Peminjaman::with('book')
        ->where('user_id', auth()->id())
        ->get();

        return view('list_peminjaman', compact('pinjamans'));
    }

    public function adminPeminjamanPage() {
        if (!auth()->check()) return redirect()->route('login');
        if (!auth()->user()->hasPermission(Roles::PINJAM_LIHAT_SEMUA | Roles::ADMINISTRATOR)) return redirect()->route('index');

        $pinjamans = Peminjaman::with('user')->get();
        return view('admin.peminjaman', compact('pinjamans'));
    }

    public function pinjamanById(Request $req) {
        $validator = Validator::make($req->all(), [
            'id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->first()
            ], 403);
        }

        $pinjaman = Peminjaman::with(['book', 'user'])->findOrFail($req->id);
        $pinjaman->denda = number_format($pinjaman->calculateDenda(), 0, '.', ',');
        
        return response()->json($pinjaman);
    }

    public function addPinjamBuku(Request $req) {
        $validator = Validator::make($req->all(), [
            'book_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->first()
            ], 403);
        }

        Peminjaman::create([
            'user_id' => auth()->id(),
            'book_id' => $req->book_id
        ]);

        $buku = Buku::findOrFail($req->book_id);
        $buku->stok--;
        $buku->save();
        
        return response()->json($buku);
    }

    public function kembalikanPinjamanBuku(Request $req) {
        $validator = Validator::make($req->all(), [
            'id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->first()
            ], 403);
        }

        $pinjaman = Peminjaman::findOrFail($req->id);
        $buku = Buku::findOrFail($pinjaman->book_id);
        $buku->stok++;
        $pinjaman->tanggal_kembali = now();
        $pinjaman->status = "dikembalikan";
        $pinjaman->save();
        $buku->save();

        return response()->json($buku->all(), 200);
    }
}
