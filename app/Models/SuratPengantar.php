<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPengantar extends Model
{
    use HasFactory;
    protected $table = 'surat_pengantars';

    protected $fillable = [
        'mahasiswa_id',
        'lokasi_penelitian',
        'penerima_surat',
        'alamat_surat',
        'tembusan_surat',
        'status_bapendik',
        'tanggal_pengambilan',
        'tahun_akademik',
        'tanggal_pengajuan',
        'catatan_bapendik',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function pengajuanKp()
    {
        return $this->hasOne(PengajuanKp::class); // Atau hasMany jika satu surat bisa untuk banyak pengajuan KP (jarang terjadi)
    }
}
