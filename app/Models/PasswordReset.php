<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    protected $table = 'password_resets';
    protected $primaryKey = 'email'; 
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'email',
        'ver_code',
        'created_at'
    ];
    
    protected $casts = [
        'created_at' => 'datetime', 
    ];
}