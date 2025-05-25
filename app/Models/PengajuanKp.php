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
}
