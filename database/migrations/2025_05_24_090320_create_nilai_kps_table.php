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
        Schema::create('nilai_kps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_kp_id')->constrained('pengajuan_kps')->cascadeOnDelete();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            // Relasi ke dosen yang memberi nilai
            // Jika dosen dihapus, nilai tetap ada (foreign key menjadi NULL)
            $table->foreignId('dosen_pembimbing_id')->nullable()->constrained('dosens')->onDelete('set null');
            $table->decimal('nilai',5,2);
            $table->string('nilai_huruf',3);
            $table->text('catatan_desen')->nullable();
            $table->date('tanggal_penilaian');
            $table->boolean('sudah_diupload')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_kps');
    }
};
