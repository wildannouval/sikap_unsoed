<?php

namespace App\Exports;

use App\Models\PengajuanKp;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanKpLengkapExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = PengajuanKp::query()->with(['mahasiswa.user', 'mahasiswa.jurusan', 'dosenPembimbing.user', 'seminars']);

        // Terapkan filter jika ada
        if (!empty($this->filters['jurusan_id'])) {
            $query->whereHas('mahasiswa', function ($q) {
                $q->where('jurusan_id', $this->filters['jurusan_id']);
            });
        }
        if (!empty($this->filters['status_kp'])) {
            $query->where('status_kp', $this->filters['status_kp']);
        }
        if (!empty($this->filters['tanggal_mulai'])) {
            $query->whereDate('tanggal_mulai_kp', '>=', $this->filters['tanggal_mulai']);
        }
        if (!empty($this->filters['tanggal_selesai'])) {
            $query->whereDate('tanggal_selesai_kp', '<=', $this->filters['tanggal_selesai']);
        }

        return $query->orderBy('tanggal_pengajuan', 'desc');
    }

    public function headings(): array
    {
        return [
            'NIM', 'Nama Mahasiswa', 'Jurusan', 'Judul KP', 'Instansi',
            'Dosen Pembimbing', 'Status KP', 'Tanggal Mulai', 'Tanggal Selesai',
            'Nilai Akhir (Angka)', 'Nilai Akhir (Huruf)',
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
            $pengajuan->dosenPembimbing->user->name ?? 'Belum Ditentukan',
            ucfirst(str_replace('_', ' ', $pengajuan->status_kp)),
            $pengajuan->tanggal_mulai_kp ? $pengajuan->tanggal_mulai_kp->format('d-m-Y') : '-',
            $pengajuan->tanggal_selesai_kp ? $pengajuan->tanggal_selesai_kp->format('d-m-Y') : '-',
            $pengajuan->nilai_akhir_angka ?? '-',
            $pengajuan->nilai_akhir_huruf ?? '-',
        ];
    }
}
