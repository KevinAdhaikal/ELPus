<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function listPeminjamanPage() {
        $pinjamans = Peminjaman::all();
        return view('list_peminjaman', compact('pinjamans'));
    }
}
