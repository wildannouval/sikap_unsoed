<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
      'tanggal_pengajuan_seminar' => 'date',
      'tanggal_seminar' => 'date'
        // 'jam_mulai' => 'datetime:H:i', // Atau biarkan sebagai string jika tidak sering dimanipulasi
        // 'jam_selesai' => 'datetime:H:i',
    ];
    // Relasi: Jadwal seminar ini milik satu pengajuan kp
    public function pengajuanKp()
    {
        return $this->belongsTo(PengajuanKp::class,'pengajuan_kp_id');
    }

    // Relasi: Jadwal semianr ini untuk satu mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
