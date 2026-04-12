<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'bukus';

    protected $fillable = [
        'nama_buku',
        'cover_buku',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'stok'
    ];
    
    public function getStatusAttribute($value)
    {
        return $this->stok > 0 ? 'available' : 'unavailable';
    }
}