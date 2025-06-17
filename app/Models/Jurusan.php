<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusans';
    protected $fillable = [
        'kode',
        'nama',
        'fakultas',
        'jenjang',
    ];

    // Relasi: Satu jurusan memiliki banyak mahasiswa
    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    // Relasi: Satu jurusan memiliki banyak dosen
    public function dosens()
    {
        return $this->hasMany(Dosen::class);
    }
}
