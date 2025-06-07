<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\Jurusan; // Untuk filter
use Illuminate\Http\Request;

class JadwalSeminarPublikController extends Controller
{
    public function index(Request $request)
    {
        $query = Seminar::where('status_pengajuan', 'dijadwalkan_komisi') // Hanya yang sudah dijadwalkan final
        ->with(['mahasiswa.user', 'mahasiswa.jurusan', 'pengajuanKp.dosenPembimbing.user'])
            ->orderBy('tanggal_seminar', 'asc')
            ->orderBy('jam_mulai', 'asc');

        // Filter berdasarkan jurusan mahasiswa
        if ($request->filled('jurusan_id')) {
            $query->whereHas('mahasiswa.jurusan', function ($q) use ($request) {
                $q->where('id', $request->jurusan_id);
            });
        }
        // Filter berdasarkan tanggal (rentang atau tanggal spesifik)
        if ($request->filled('tanggal_filter')) {
            $query->whereDate('tanggal_seminar', $request->tanggal_filter);
        }

        // Search (nama mahasiswa, nim, judul kp)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul_kp_final', 'like', "%{$searchTerm}%")
                    ->orWhereHas('mahasiswa.user', function ($subQ) use ($searchTerm) {
                        $subQ->where('name', 'like', "%{$searchTerm}%");
                    })
                    ->orWhereHas('mahasiswa', function ($subQ) use ($searchTerm) {
                        $subQ->where('nim', 'like', "%{$searchTerm}%");
                    });
            });
        }

        $seminars = $query->paginate(15)->appends($request->query()); // Tampilkan lebih banyak per halaman
        $jurusans = Jurusan::orderBy('nama')->get();

        return view('jadwal_seminar_publik.index', compact('seminars', 'jurusans', 'request'));
    }
}
