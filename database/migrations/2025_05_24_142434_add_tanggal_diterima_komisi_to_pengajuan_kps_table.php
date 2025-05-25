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
            // Tambahkan kolom baru setelah kolom 'alasan_tidak_layak' atau posisi lain yang sesuai
            // Kolom ini bisa null karena baru diisi saat komisi menyetujui
            $table->date('tanggal_diterima_komisi')->nullable()->after('alasan_ditolak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_kps', function (Blueprint $table) {
            $table->dropColumn('tanggal_diterima_komisi');
        });
    }
};
