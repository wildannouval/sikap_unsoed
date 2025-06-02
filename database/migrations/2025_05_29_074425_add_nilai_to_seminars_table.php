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
        Schema::table('seminars', function (Blueprint $table) {
            Schema::table('seminars', function (Blueprint $table) {
                $table->decimal('nilai_seminar_angka', 5, 2)->nullable()->after('berita_acara_path'); // Misal, nilai 0.00 - 999.99 (atau sesuaikan presisinya)
                // Atau jika hanya integer: $table->unsignedTinyInteger('nilai_seminar_angka')->nullable()->after('berita_acara_path');
                $table->text('catatan_hasil_seminar')->nullable()->after('nilai_seminar_angka'); // Catatan dari dospem terkait hasil
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seminars', function (Blueprint $table) {
            Schema::table('seminars', function (Blueprint $table) {
                $table->dropColumn('nilai_seminar_angka');
                $table->dropColumn('catatan_hasil_seminar');
            });
        });
    }
};
