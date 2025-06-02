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
        Schema::table('pengajuan_kps', function (Blueprint $table) {
            // Tambahkan setelah kolom yang relevan, misalnya setelah status_kp
            $table->decimal('nilai_akhir_angka', 5, 2)->nullable()->after('status_kp');
            $table->string('nilai_akhir_huruf', 3)->nullable()->after('nilai_akhir_angka');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_kps', function (Blueprint $table) {
            $table->dropColumn(['nilai_akhir_angka', 'nilai_akhir_huruf']);
        });
    }
};
