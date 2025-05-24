<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $table = 'dosens';
    protected $fillable = [
        'user_id',
        'jurusan_id',
        'nidn',
        'bidang_keahlian',
        'is_komisi',
    ];

    // Relasi: Prodil dosen ini dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Dosen ini berasal dari satu jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
