<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = [
        'name',
        'permission_level',
    ];

    // ADMINISTRATOR
    const ADMINISTRATOR = 1 << 0;

    // =========================
    // MEMBER ACCESS
    // =========================
    const DAFTAR_BUKU = 1 << 1;
    const PINJAM_BUAT = 1 << 2;
    const PINJAM_LIHAT_SENDIRI = 1 << 3;
    const PINJAM_BATAL = 1 << 4;

    // =========================
    // MANAJEMEN BUKU
    // =========================
    const MANAJEMEN_BUKU_LIHAT = 1 << 5;
    const MANAJEMEN_BUKU_TAMBAH = 1 << 6;
    const MANAJEMEN_BUKU_EDIT = 1 << 7;
    const MANAJEMEN_BUKU_HAPUS = 1 << 8;

    // =========================
    // MANAJEMEN PEMINJAMAN
    // =========================
    const PINJAM_SETUJUI = 1 << 9;
    const PINJAM_KEMBALI = 1 << 10;
    const PINJAM_LIHAT_SEMUA = 1 << 11;

    // =========================
    // LAINNYA
    // =========================
    const LAPORAN_LIHAT = 1 << 12;
    const DENDA_KELOLA = 1 << 13;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // helper cek permission
}