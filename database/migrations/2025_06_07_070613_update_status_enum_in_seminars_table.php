<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menggunakan DB::statement untuk mengubah ENUM di MySQL
        DB::statement("ALTER TABLE seminars MODIFY COLUMN status_pengajuan ENUM('diajukan_mahasiswa', 'revisi_dospem', 'disetujui_dospem', 'ditolak_dospem', 'dijadwalkan_bapendik', 'revisi_jadwal_bapendik', 'dibatalkan', 'selesai_dinilai') NOT NULL DEFAULT 'diajukan_mahasiswa'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke definisi ENUM sebelumnya
        DB::statement("ALTER TABLE seminars MODIFY COLUMN status_pengajuan ENUM('diajukan_mahasiswa', 'disetujui_dospem', 'ditolak_dospem', 'dijadwalkan_komisi', 'selesai_dinilai', 'dibatalkan', 'revisi_jadwal_komisi') NOT NULL DEFAULT 'diajukan_mahasiswa'");
    }
};
