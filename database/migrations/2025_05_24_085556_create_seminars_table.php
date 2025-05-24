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
            // relasi ke pengajuan kp
            $table->foreignId('poengajuan_kp_id')->constrained('pengajuan_kps')->cascadeOnDelete();
            // relasi ke mahasiswa yang bersangkutan
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->string('judul_kp_final');
            $table->date('tanggal_seminar');
            $table->string('ruangan');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('berita_acara_path')->nullable();
            $table->boolean('disetujui_bapendik')->default(false);
            $table->text('catatan_seminar');
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
