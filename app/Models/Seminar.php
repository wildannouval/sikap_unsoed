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
      'tanggal_seminar' => 'date',
        'nilai_seminar_angka' => 'decimal:2',
        'ba_tanggal_pengambilan' => 'date',
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

    /**
     * Accessor untuk mendapatkan nilai seminar dalam bentuk huruf.
     *
     * @return string|null
     */
    public function getNilaiSeminarHurufAttribute(): ?string
    {
        $nilaiAngka = $this->nilai_seminar_angka;

        if (is_null($nilaiAngka)) {
            return null; // Atau '-' jika nilai angka belum ada
        }

        if ($nilaiAngka >= 80) {
            return 'A';
        } elseif ($nilaiAngka >= 75) {
            return 'AB';
        } elseif ($nilaiAngka >= 70) {
            return 'B';
        } elseif ($nilaiAngka >= 65) {
            return 'BC';
        } elseif ($nilaiAngka >= 60) {
            return 'C';
        } elseif ($nilaiAngka >= 50) {
            return 'CD';
        } else {
            return 'D';
        }
    }
}
