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
        Schema::create('konsultasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_kp_id')->constrained()->cascadeOnDelete();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->foreignId('dosen_pembimbing_id')->constrained('dosens')->cascadeOnDelete();
            $table->date('tanggal_konsultasi');
            $table->string('topik_konsultasi');
            $table->text('hasil_konsultasi');
            $table->boolean('diverifikasi')->default(false);
            $table->dateTime('tanggal_verifikasi')->nullable();
            $table->text('catatan_dosen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasis');
    }
};
