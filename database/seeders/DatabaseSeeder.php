<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SuratPengantar;
use App\Models\PengajuanKp;
use App\Models\Konsultasi;
use App\Models\Seminar;
use App\Models\Distribusi;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Jurusan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        // 1. Jalankan Seeder untuk data master
        $this->call([
            JurusanSeeder::class,
            RuanganSeeder::class,
        ]);

        // Ambil jurusan "Teknik Informatika" untuk semua user demo
        $jurusanInformatika = Jurusan::where('kode', 'IF')->first();

        // 2. Buat Akun-Akun Penting untuk Demo (password untuk semua: "password")
        $bapendikUser = User::factory()->create(['name' => 'Admin Bapendik', 'email' => 'bapendik@sikap.test', 'role' => 'bapendik']);
        $dosenKomisiUser = User::factory()->create(['name' => 'Dr. Komisi', 'email' => 'komisi@sikap.test', 'role' => 'dosen']);
        $dosenKomisi = Dosen::factory()->create(['user_id' => $dosenKomisiUser->id, 'jurusan_id' => $jurusanInformatika->id, 'nidn' => '0011223301', 'is_komisi' => true]);
        $dosenPembimbingUser = User::factory()->create(['name' => 'Dr. Retno', 'email' => 'dospem@sikap.test', 'role' => 'dosen']);
        $dosenPembimbing = Dosen::factory()->create(['user_id' => $dosenPembimbingUser->id, 'jurusan_id' => $jurusanInformatika->id, 'nidn' => '0011223302', 'is_komisi' => false]);

        // 3. Buat beberapa skenario mahasiswa untuk didemokan
        // SKENARIO 1: MAHASISWA BARU (untuk demo tahap paling awal)
        $mhsBaruUser = User::factory()->create(['name' => 'Citra Lestari', 'email' => 'citra@sikap.test', 'role' => 'mahasiswa']);
        $mhsBaru = Mahasiswa::factory()->create(['user_id' => $mhsBaruUser->id, 'jurusan_id' => $jurusanInformatika->id, 'nim' => 'H1D022001']);
        SuratPengantar::factory()->create(['mahasiswa_id' => $mhsBaru->id, 'status_bapendik' => 'menunggu']); // TUGAS UNTUK BAPENDIK

        // SKENARIO 2: MAHASISWA YANG SUDAH AJUKAN KP (untuk demo Komisi)
        $mhsAjukanKpUser = User::factory()->create(['name' => 'Doni Firmansyah', 'email' => 'doni@sikap.test', 'role' => 'mahasiswa']);
        $mhsAjukanKp = Mahasiswa::factory()->create(['user_id' => $mhsAjukanKpUser->id, 'jurusan_id' => $jurusanInformatika->id, 'nim' => 'H1D022002']);
        $suratPengantarDoni = SuratPengantar::factory()->create(['mahasiswa_id' => $mhsAjukanKp->id, 'status_bapendik' => 'disetujui']);
        PengajuanKp::factory()->create(['mahasiswa_id' => $mhsAjukanKp->id, 'surat_pengantar_id' => $suratPengantarDoni->id, 'status_komisi' => 'direview']); // TUGAS UNTUK KOMISI

        // SKENARIO 3: MAHASISWA DEMO UTAMA (Budi Sanjaya)
        $mhsDemoUser = User::factory()->create(['name' => 'Budi Sanjaya', 'email' => 'budi@sikap.test', 'role' => 'mahasiswa']);
        $mhsDemo = Mahasiswa::factory()->create(['user_id' => $mhsDemoUser->id, 'jurusan_id' => $jurusanInformatika->id, 'nim' => 'H1D021001']);

        $suratPengantarBudi = SuratPengantar::factory()->create(['mahasiswa_id' => $mhsDemo->id, 'status_bapendik' => 'disetujui']);
        $pengajuanKpBudi = PengajuanKp::factory()->create([
            'mahasiswa_id' => $mhsDemo->id,
            'surat_pengantar_id' => $suratPengantarBudi->id,
            'status_komisi' => 'diterima',
            'dosen_pembimbing_id' => $dosenPembimbing->id,
            'status_kp' => 'dalam_proses',
            'tanggal_diterima_komisi' => now()->subWeeks(2),
        ]);
        Konsultasi::factory(5)->create([ // Buat 5 agar demo verifikasi & pengajuan seminar pas
            'pengajuan_kp_id' => $pengajuanKpBudi->id,
            'mahasiswa_id' => $mhsDemo->id,
            'dosen_pembimbing_id' => $dosenPembimbing->id,
            'diverifikasi' => true,
            'tanggal_verifikasi' => now()->subDay()
        ]);
        Konsultasi::factory(1)->create([ // 1 konsultasi yang belum diverifikasi
            'pengajuan_kp_id' => $pengajuanKpBudi->id,
            'mahasiswa_id' => $mhsDemo->id,
            'dosen_pembimbing_id' => $dosenPembimbing->id,
            'diverifikasi' => false,
        ]); // TUGAS UNTUK DOSEN PEMBIMBING (VERIFIKASI)

        // Membuat data seminar yang siap disetujui Dospem (jika ingin demo persetujuan)
        Seminar::factory()->create([
            'pengajuan_kp_id' => $pengajuanKpBudi->id,
            'mahasiswa_id' => $mhsDemo->id,
            'status_pengajuan' => 'diajukan_mahasiswa', // TUGAS UNTUK DOSEN PEMBIMBING (APPROVAL SEMINAR)
        ]);

    }
}
//    public function run(): void
//    {
//        // 1. Jalankan Seeder untuk data master
//        $this->call([
//            JurusanSeeder::class,
//            RuanganSeeder::class,
//        ]);
//
//        $jurusanInformatika = Jurusan::where('kode', 'IF')->first();
//        if (!$jurusanInformatika) {
//            $jurusanInformatika = Jurusan::factory()->create(['kode' => 'IF', 'nama' => 'Teknik Informatika']);
//        }
//
//        // 2. Buat Akun-Akun Penting untuk Demo (password untuk semua adalah: "password")
//
//        // A. Bapendik
//        $bapendikUser = User::factory()->create([
//            'name' => 'Admin Bapendik',
//            'email' => 'bapendik@sikap.test',
//            'role' => 'bapendik',
//        ]);
//
//        // B. Dosen Komisi
//        $dosenKomisiUser = User::factory()->create(['name' => 'Dr. Dosen Komisi', 'email' => 'komisi@sikap.test', 'role' => 'dosen']);
//        $dosenKomisi = Dosen::factory()->create(['user_id' => $dosenKomisiUser->id, 'jurusan_id' => $jurusanInformatika->id, 'nidn' => '0011223301', 'is_komisi' => true]);
//
//        // C. Dosen Pembimbing
//        $dosenPembimbingUser = User::factory()->create(['name' => 'Dr. Dosen Pembimbing', 'email' => 'dospem@sikap.test', 'role' => 'dosen']);
//        $dosenPembimbing = Dosen::factory()->create(['user_id' => $dosenPembimbingUser->id, 'jurusan_id' => $jurusanInformatika->id, 'nidn' => '0011223302', 'is_komisi' => false]);
//
//        // D. Mahasiswa dengan Alur KP Lengkap
//        $mahasiswaDemoUser = User::factory()->create(['name' => 'Mahasiswa Demo', 'email' => 'mahasiswa@sikap.test', 'role' => 'mahasiswa']);
//        $mahasiswa = Mahasiswa::factory()->create(['user_id' => $mahasiswaDemoUser->id, 'jurusan_id' => $jurusanInformatika->id, 'nim' => 'H1D021001']);
//
//        // --- TAMBAHAN: MAHASISWA BARU (BELUM ADA ALUR KP) ---
//        $mahasiswaBaruUser = User::factory()->create([
//            'name' => 'Mahasiswa Baru',
//            'email' => 'mahasiswabaru@sikap.test',
//            'role' => 'mahasiswa',
//        ]);
//        Mahasiswa::factory()->create([
//            'user_id' => $mahasiswaBaruUser->id,
//            'jurusan_id' => $jurusanInformatika->id,
//            'nim' => 'H1D022002',
//        ]);
//        // --- AKHIR TAMBAHAN ---
//
//        // 3. Buat SATU Alur KP Lengkap untuk Mahasiswa Demo
//
//        // Tahap 1: Surat Pengantar disetujui
//        $suratPengantar = SuratPengantar::factory()->create([
//            'mahasiswa_id' => $mahasiswa->id,
//            'status_bapendik' => 'disetujui',
//            'lokasi_penelitian' => 'PT. Inovasi Digital Nusantara',
//            'tanggal_pengambilan' => now()->subMonths(4),
//        ]);
//
//        // Tahap 2: Pengajuan KP disetujui Komisi & Dospem ditetapkan
//        $pengajuanKp = PengajuanKp::factory()->create([
//            'mahasiswa_id' => $mahasiswa->id,
//            'surat_pengantar_id' => $suratPengantar->id,
//            'judul_kp' => 'Implementasi Sistem Notifikasi Real-time pada Aplikasi SIKAP',
//            'instansi_lokasi' => 'PT. Inovasi Digital Nusantara',
//            'status_komisi' => 'diterima',
//            'dosen_pembimbing_id' => $dosenPembimbing->id,
//            'tanggal_diterima_komisi' => now()->subMonths(3),
//            'tanggal_mulai_kp' => now()->subMonths(2),
//            'tanggal_selesai_kp' => now()->addMonth(),
//            'status_kp' => 'dalam_proses',
//            'proposal_kp' => 'proposal_kp/contoh_proposal.pdf',
//            'surat_keterangan' => 'surat_keterangan_instansi/contoh_surat.pdf',
//            'spk_dicetak_at' => now()->subMonths(3)->addWeek(),
//            'spk_diambil_at' => now()->subMonths(3)->addWeek(),
//        ]);
//
//        // Tahap 3: Riwayat konsultasi (6 terverifikasi, 1 belum)
//        Konsultasi::factory(6)->create([
//            'pengajuan_kp_id' => $pengajuanKp->id,
//            'mahasiswa_id' => $mahasiswa->id,
//            'dosen_pembimbing_id' => $dosenPembimbing->id,
//            'diverifikasi' => true, 'tanggal_verifikasi' => now()
//        ]);
//        Konsultasi::factory(1)->create([
//            'pengajuan_kp_id' => $pengajuanKp->id,
//            'mahasiswa_id' => $mahasiswa->id,
//            'dosen_pembimbing_id' => $dosenPembimbing->id,
//            'diverifikasi' => false
//        ]);
//
//        // Tahap 4: Pengajuan seminar yang sudah disetujui Dospem
//        Seminar::factory()->create([
//            'pengajuan_kp_id' => $pengajuanKp->id,
//            'mahasiswa_id' => $mahasiswa->id,
//            'status_pengajuan' => 'disetujui_dospem', // Menunggu dijadwalkan Bapendik
//            'dospem_approved_at' => now()->subDays(2),
//        ]);
//    }

