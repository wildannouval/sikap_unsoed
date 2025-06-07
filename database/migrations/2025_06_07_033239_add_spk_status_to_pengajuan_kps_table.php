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
            // Tambahkan kolom-kolom ini setelah kolom 'status_kp'
            $table->timestamp('spk_dicetak_at')->nullable()->after('status_kp'); // Untuk menandai kapan SPK dicetak
            $table->timestamp('spk_diambil_at')->nullable()->after('spk_dicetak_at'); // Untuk menandai kapan SPK diambil mhs
            $table->text('catatan_spk')->nullable()->after('spk_diambil_at'); // Catatan dari Bapendik terkait SPK
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_kps', function (Blueprint $table) {
            $table->dropColumn(['spk_dicetak_at', 'spk_diambil_at', 'catatan_spk']);
        });
    }
};
