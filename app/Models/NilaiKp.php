<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKp extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi: Nilai ini milik satu pengajuan KP
    public function pengajuanKp()
    {
        return $this->belongsTo(PengajuanKp::class, 'pengajuan_kp_id');
    }

    // Relasi: Nilai ini untuk satu Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    // Relasi: Nilai ini diberikan oleh satu dosen pembimbing
    public function dosenPembimbing()
    {
        return $this->belongsTo(Dosen::class,'dosen_pembimbing_id');
    }
}
