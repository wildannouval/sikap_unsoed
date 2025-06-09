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
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Jalankan JurusanSeeder
        $this->call([
            JurusanSeeder::class,
            RuanganSeeder::class,
        ]);

        $jurusanInformatika = Jurusan::where('kode', 'IF')->first();
        if (!$jurusanInformatika) {
            $jurusanInformatika = Jurusan::factory()->create(['kode' => 'IF', 'nama' => 'Teknik Informatika']);
        }

        // 2. Buat Akun-Akun Penting untuk Demo (password untuk semua adalah: "password")

        // A. Bapendik
        $bapendikUser = User::factory()->create([
            'name' => 'Admin Bapendik',
            'email' => 'bapendik@sikap.test',
            'role' => 'bapendik',
        ]);

        // B. Dosen Komisi
        $dosenKomisiUser = User::factory()->create(['name' => 'Dr. Dosen Komisi', 'email' => 'komisi@sikap.test', 'role' => 'dosen']);
        $dosenKomisi = Dosen::factory()->create(['user_id' => $dosenKomisiUser->id, 'jurusan_id' => $jurusanInformatika->id, 'nidn' => '0011223301', 'is_komisi' => true]);

        // C. Dosen Pembimbing
        $dosenPembimbingUser = User::factory()->create(['name' => 'Dr. Dosen Pembimbing', 'email' => 'dospem@sikap.test', 'role' => 'dosen']);
        $dosenPembimbing = Dosen::factory()->create(['user_id' => $dosenPembimbingUser->id, 'jurusan_id' => $jurusanInformatika->id, 'nidn' => '0011223302', 'is_komisi' => false]);

        // D. Mahasiswa dengan Alur KP Lengkap
        $mahasiswaDemoUser = User::factory()->create(['name' => 'Mahasiswa Demo', 'email' => 'mahasiswa@sikap.test', 'role' => 'mahasiswa']);
        $mahasiswa = Mahasiswa::factory()->create(['user_id' => $mahasiswaDemoUser->id, 'jurusan_id' => $jurusanInformatika->id, 'nim' => 'H1D021001']);

        // --- TAMBAHAN: MAHASISWA BARU (BELUM ADA ALUR KP) ---
        $mahasiswaBaruUser = User::factory()->create([
            'name' => 'Mahasiswa Baru',
            'email' => 'mahasiswabaru@sikap.test',
            'role' => 'mahasiswa',
        ]);
        Mahasiswa::factory()->create([
            'user_id' => $mahasiswaBaruUser->id,
            'jurusan_id' => $jurusanInformatika->id,
            'nim' => 'H1D022002',
        ]);
        // --- AKHIR TAMBAHAN ---

        // 3. Buat SATU Alur KP Lengkap untuk Mahasiswa Demo

        // Tahap 1: Surat Pengantar disetujui
        $suratPengantar = SuratPengantar::factory()->create([
            'mahasiswa_id' => $mahasiswa->id,
            'status_bapendik' => 'disetujui',
            'lokasi_penelitian' => 'PT. Inovasi Digital Nusantara',
            'tanggal_pengambilan' => now()->subMonths(4),
        ]);

        // Tahap 2: Pengajuan KP disetujui Komisi & Dospem ditetapkan
        $pengajuanKp = PengajuanKp::factory()->create([
            'mahasiswa_id' => $mahasiswa->id,
            'surat_pengantar_id' => $suratPengantar->id,
            'judul_kp' => 'Implementasi Sistem Notifikasi Real-time pada Aplikasi SIKAP',
            'instansi_lokasi' => 'PT. Inovasi Digital Nusantara',
            'status_komisi' => 'diterima',
            'dosen_pembimbing_id' => $dosenPembimbing->id,
            'tanggal_diterima_komisi' => now()->subMonths(3),
            'tanggal_mulai_kp' => now()->subMonths(2),
            'tanggal_selesai_kp' => now()->addMonth(),
            'status_kp' => 'dalam_proses',
            'proposal_kp' => 'proposal_kp/contoh_proposal.pdf',
            'surat_keterangan' => 'surat_keterangan_instansi/contoh_surat.pdf',
            'spk_dicetak_at' => now()->subMonths(3)->addWeek(),
            'spk_diambil_at' => now()->subMonths(3)->addWeek(),
        ]);

        // Tahap 3: Riwayat konsultasi (6 terverifikasi, 1 belum)
        Konsultasi::factory(6)->create([
            'pengajuan_kp_id' => $pengajuanKp->id,
            'mahasiswa_id' => $mahasiswa->id,
            'dosen_pembimbing_id' => $dosenPembimbing->id,
            'diverifikasi' => true, 'tanggal_verifikasi' => now()
        ]);
        Konsultasi::factory(1)->create([
            'pengajuan_kp_id' => $pengajuanKp->id,
            'mahasiswa_id' => $mahasiswa->id,
            'dosen_pembimbing_id' => $dosenPembimbing->id,
            'diverifikasi' => false
        ]);

        // Tahap 4: Pengajuan seminar yang sudah disetujui Dospem
        Seminar::factory()->create([
            'pengajuan_kp_id' => $pengajuanKp->id,
            'mahasiswa_id' => $mahasiswa->id,
            'status_pengajuan' => 'disetujui_dospem', // Menunggu dijadwalkan Bapendik
            'dospem_approved_at' => now()->subDays(2),
        ]);
    }
}
