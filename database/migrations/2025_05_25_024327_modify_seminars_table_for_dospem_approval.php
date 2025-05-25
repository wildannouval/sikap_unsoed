<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('seminars', function (Blueprint $table) {
            // Ubah enum status_pengajuan
            // Perhatian: Mengubah enum di MySQL memerlukan DB::statement untuk beberapa versi
            // Cara aman biasanya drop kolom dan buat lagi jika tidak ada data penting
            // Atau, pastikan semua data lama sesuai dengan salah satu nilai enum baru atau diupdate
            // Untuk kemudahan, kita asumsikan bisa diubah langsung jika didukung driver DB atau belum banyak data.
            // Jika tidak bisa, alternatifnya adalah menggunakan string biasa dan validasi di level aplikasi.
            $table->enum('status_pengajuan', [
                'diajukan_mahasiswa',    // Diajukan oleh mahasiswa
                'disetujui_dospem',     // Disetujui Dosen Pembimbing, menunggu penjadwalan Komisi
                'ditolak_dospem',       // Ditolak oleh Dosen Pembimbing
                'dijadwalkan_komisi',   // Jadwal final ditetapkan oleh Komisi/Bapendik
                'selesai_dinilai',      // Seminar selesai dan sudah dinilai
                'dibatalkan',           // Dibatalkan (oleh mahasiswa atau admin)
                'revisi_jadwal_komisi'  // Komisi meminta mahasiswa revisi usulan jadwal (setelah dospem setuju)
            ])->default('diajukan_mahasiswa')->change(); // Tambahkan ->change()

            $table->text('catatan_dospem')->nullable()->after('catatan_mahasiswa');
            $table->timestamp('dospem_approved_at')->nullable()->after('catatan_dospem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seminars', function (Blueprint $table) {
            // Untuk rollback, kembalikan ke definisi enum sebelumnya atau state yang aman
            // Ini bisa kompleks, pastikan backup data jika perlu.
            $table->enum('status_pengajuan', [
                'diajukan', // Ini dari definisi awal kita, sesuaikan jika beda
                'dijadwalkan',
                'selesai_dinilai',
                'dibatalkan',
                'revisi_jadwal'
            ])->default('diajukan')->change();

            $table->dropColumn('catatan_dospem');
            $table->dropColumn('dospem_approved_at');
        });
    }
};
