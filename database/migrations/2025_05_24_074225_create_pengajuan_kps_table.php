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
        Schema::create('pengajuan_kps', function (Blueprint $table) {
            $table->id();
            $table->string('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->foreignId('surat_pengantar_id')->constrained()->cascadeOnDelete();
            $table->foreignId('dosen_pembimbing_id')->nullable()->constrained('dosens')->onDelete('set null');// Menggunakan onDelete('set null') agar jika dosen dihapus, data pengajuan tidak ikut hilang\
            $table->string('judul_kp');
            $table->string('instansi_lokasi');
            $table->string('proposal_kp')->nullable();
            $table->string('surat_keterangan')->nullable();
            $table->date('tanggal_pengajuan');
            $table->enum('status_komisi',['direview','diterima','ditolak'])->default('direview');
            $table->text('alasan_ditolak')->nullable();
            $table->date('tanggal_mulai_kp')->nullable();
            $table->date('tanggal_selesai_kp')->nullable();
            $table->enum('status_kp', ['pengajuan', 'dalam_proses', 'selesai', 'lulus', 'tidak_lulus'])->default('pengajuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_kps');
    }
};
