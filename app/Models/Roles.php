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
    const BUKU_LIHAT = 1 << 1;
    const PINJAM_BUAT = 1 << 2;
    const PINJAM_LIHAT_SENDIRI = 1 << 3;
    const PINJAM_BATAL = 1 << 4;

    // =========================
    // MANAJEMEN BUKU
    // =========================
    const BUKU_TAMBAH = 1 << 5;
    const BUKU_EDIT = 1 << 6;
    const BUKU_HAPUS = 1 << 7;

    // =========================
    // MANAJEMEN PEMINJAMAN
    // =========================
    const PINJAM_SETUJUI = 1 << 8;
    const PINJAM_KEMBALI = 1 << 9;
    const PINJAM_LIHAT_SEMUA = 1 << 10;

    // =========================
    // MANAJEMEN USER
    // =========================
    const USER_LIHAT = 1 << 11;
    const USER_TAMBAH = 1 << 12;
    const USER_EDIT = 1 << 13;
    const USER_HAPUS = 1 << 14;

    // =========================
    // LAINNYA
    // =========================
    const LAPORAN_LIHAT = 1 << 15;
    const DENDA_KELOLA = 1 << 16;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // helper cek permission
    public function hasPermission($perm)
    {
        return ($this->permission_level & $perm) === $perm;
    }
}