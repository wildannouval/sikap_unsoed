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
//        Schema::create('distribusis', function (Blueprint $table) {
//            $table->id();
//            $table->foreignId('pengajuan_kp_id')->constrained('pengajuan_kps')->cascadeOnDelete();
//            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
//            $table->string('judul_kp_final');
//            $table->string('berkas_distribusi');
//            $table->date('tanggal_distribusi');
//            $table->text('catatan')->nullable();
//            $table->timestamps();
//        });

        Schema::create('distribusis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_kp_id')->constrained('pengajuan_kps')->cascadeOnDelete();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            // judul_kp_final bisa diambil dari pengajuan_kp->judul_kp atau seminar->judul_kp_final saat create
            // Jika ingin disimpan denormalisasi:
            // $table->string('judul_kp_final');
            $table->string('berkas_distribusi')->comment('Path ke file bukti distribusi');
            $table->date('tanggal_distribusi');
            $table->text('catatan_mahasiswa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusis');
    }
};
