<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_kembali',
        'status',
        'denda'
    ];

    protected $dates = [
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_kembali'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_jatuh_tempo' => 'datetime',
        'tanggal_kembali' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function book()
    {
        return $this->belongsTo(Buku::class, 'book_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($peminjaman) {
            $peminjaman->tanggal_pinjam = now();
            $peminjaman->tanggal_jatuh_tempo = now()->addDays(7);
            $peminjaman->status = 'dipinjam';
        });
    }

    public function isLate()
    {
        return now()->gt($this->tanggal_jatuh_tempo) && $this->status !== 'dikembalikan';
    }

    public function calculateDenda()
    {
        $tanggal_late = $this->tanggal_kembali ?? $this->tanggal_jatuh_tempo;
        if (now()->lessThan($tanggal_late)) {
            return 0;
        }
        
        $daysLate = Carbon::parse($tanggal_late)->diffInDays(now());

        return $daysLate * 1000;
    }
}