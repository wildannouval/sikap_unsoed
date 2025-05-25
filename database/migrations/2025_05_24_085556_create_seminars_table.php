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
        Schema::create('seminars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_kp_id')->constrained('pengajuan_kps')->cascadeOnDelete();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();

            $table->string('judul_kp_final');
            $table->string('draft_laporan_path')->comment('Path ke file draft laporan KP');

            // Kolom untuk usulan jadwal dari mahasiswa, yang bisa diedit/dikonfirmasi Komisi
            $table->date('tanggal_seminar')->nullable(); // Awalnya diisi usulan mahasiswa
            $table->time('jam_mulai')->nullable();       // Awalnya diisi usulan mahasiswa
            $table->time('jam_selesai')->nullable();     // Awalnya diisi usulan mahasiswa
            $table->string('ruangan')->nullable();       // Awalnya diisi usulan mahasiswa

            $table->enum('status_pengajuan', [
                'diajukan_mahasiswa', // Mahasiswa mengajukan dengan usulan jadwal
                'disetujui_dospem',   // Disetujui Dospem, menunggu penjadwalan final Komisi (jika ada alur ini)
                'dijadwalkan_komisi', // Jadwal final ditetapkan oleh Komisi/Bapendik
                'selesai_dinilai',
                'dibatalkan',
                'revisi_jadwal'       // Komisi/Bapendik meminta mahasiswa revisi usulan jadwal
            ])->default('diajukan_mahasiswa');

            $table->date('tanggal_pengajuan_seminar');
            $table->text('catatan_mahasiswa')->nullable();
            $table->text('catatan_komisi')->nullable();
            $table->string('berita_acara_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminars');
    }
};
