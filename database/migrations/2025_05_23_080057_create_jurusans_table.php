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
        Schema::create('jurusans', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique(); // Contoh: "IF", "SI"
            $table->string('nama'); // Contoh: "Teknik Informatika"
            $table->string('fakultas')->default('Teknik'); // Contoh: "FTIK"
            $table->string('jenjang')->default('S1'); // S1, D3, S2, dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusans');
    }
};
