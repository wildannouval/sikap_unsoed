<?php

namespace App\Exports;

use App\Models\PengajuanKp;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BimbinganKpExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $dosenId;
    protected $searchTerm;

    public function __construct(int $dosenId, ?string $searchTerm = null)
    {
        $this->dosenId = $dosenId;
        $this->searchTerm = $searchTerm;
    }

    public function query()
    {
        $query = PengajuanKp::query()
            ->where('dosen_pembimbing_id', $this->dosenId)
            ->where('status_kp', 'dalam_proses')
            ->with(['mahasiswa.user', 'mahasiswa.jurusan']);

        if ($this->searchTerm) {
            $query->where(function($q) {
                $q->whereHas('mahasiswa.user', function ($subQ) {
                    $subQ->where('name', 'like', '%' . $this->searchTerm . '%');
                })->orWhere('judul_kp', 'like', '%' . $this->searchTerm . '%');
            });
        }

        return $query->latest('updated_at');
    }

    public function headings(): array
    {
        return [
            'NIM', 'Nama Mahasiswa', 'Jurusan', 'Judul KP', 'Instansi',
            'Jumlah Konsultasi Terverifikasi',
        ];
    }

    public function map($pengajuan): array
    {
        return [
            $pengajuan->mahasiswa->nim ?? '-',
            $pengajuan->mahasiswa->user->name ?? '-',
            $pengajuan->mahasiswa->jurusan->nama ?? '-',
            $pengajuan->judul_kp,
            $pengajuan->instansi_lokasi,
            $pengajuan->jumlah_konsultasi_verified,
        ];
    }
}
