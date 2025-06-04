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
        Schema::create('ruangans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruangan')->unique();
            $table->string('lokasi_gedung')->nullable(); // Opsional, misal: Gedung A, Lantai 2
            $table->integer('kapasitas')->nullable();   // Opsional
            $table->text('fasilitas')->nullable();      // Opsional, misal: LCD, Proyektor, AC
            $table->boolean('is_tersedia')->default(true); // Status ketersediaan umum
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangans');
    }
};
