<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_ruangan',
        'lokasi_gedung',
        'kapasitas',
        'fasilitas',
        'is_tersedia',
    ];

    protected $casts = [
        'is_tersedia' => 'boolean',
    ];
}
