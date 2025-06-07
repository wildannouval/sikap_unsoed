<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanKp extends Model
{
    use HasFactory;
    protected $table = 'pengajuan_kps';

    // menggunakan guarded agar semua kolom bisa diisi, atau definisikan di $fillable
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_diterima_komisi' => 'date',
        'nilai_akhir_angka' => 'decimal:2',
        'spk_dicetak_at' => 'datetime',
        'spk_diambil_at' => 'datetime',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function dosenPembimbing()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function suratPengantar()
    {
        return $this->belongsTo(SuratPengantar::class);
    }

    public function konsultasis()
    {
        return $this->hasMany(Konsultasi::class);
    }

    // Relasi ke Seminar
    public function seminars()
    {
        return $this->hasMany(Seminar::class);
    }

    // Accessor untuk mendapatkan jumlah konsultasi yang sudah diverifikasi
    public function getJumlahKonsultasiVerifiedAttribute()
    {
        return $this->konsultasis()->where('diverifikasi', true)->count();
    }

    // Accessor untuk mengecek apakah sudah ada pengajuan seminar aktif
    public function getHasActiveSeminarAttribute()
    {
        return $this->seminars()->whereIn('status_pengajuan', ['diajukan_mahasiswa', 'disetujui_dospem', 'dijadwalkan_komisi'])->exists();
    }

    public function distribusi()
    {
        return $this->hasOne(Distribusi::class, 'pengajuan_kp_id');
    }

    // Accessor untuk cek apakah sudah dupload bukti distribusi
    public function getSudahUploadBuktiDistribusiAttribute()
    {
        return $this->distribusi()->exists();
    }

    // Helper untuk konversi nilai angka ke huruf (bisa juga ditaruh di Service Class jika kompleks)
    // Helper untuk konversi nilai angka ke huruf (bisa juga ditaruh di Service Class jika kompleks)
    public static function konversiNilaiKeHuruf(float $nilaiAngka = null): ?string
    {
        if (is_null($nilaiAngka)) {
            return null;
        }

        if ($nilaiAngka >= 80) return 'A';
        if ($nilaiAngka >= 75) return 'AB';
        if ($nilaiAngka >= 70) return 'B';
        if ($nilaiAngka >= 65) return 'BC';
        if ($nilaiAngka >= 60) return 'C'; // Batas lulus C
        if ($nilaiAngka >= 50) return 'DC';
        return 'D';
    }
}
