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
        Schema::create('surat_pengantars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->string('lokasi_penelitian');
            $table->string('penerima_surat');
            $table->string('alamat_surat');
            $table->text('tembusan_surat')->nullable();
            $table->enum('status_bapendik', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->date('tanggal_pengambilan')->nullable();
            $table->string('tahun_akademik');
            $table->date('tanggal_pengajuan');
            $table->text('catatan_bapendik')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pengantars');
    }
};
