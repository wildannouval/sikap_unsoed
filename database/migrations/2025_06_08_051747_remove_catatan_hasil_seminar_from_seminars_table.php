<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seminars', function (Blueprint $table) {
            // Pastikan kolomnya ada sebelum mencoba menghapus
            if (Schema::hasColumn('seminars', 'catatan_hasil_seminar')) {
                $table->dropColumn('catatan_hasil_seminar');
            }
        });
    }

    public function down(): void
    {
        Schema::table('seminars', function (Blueprint $table) {
            // Jika ingin bisa di-rollback, tambahkan kolomnya kembali
            $table->text('catatan_hasil_seminar')->nullable()->after('berita_acara_path');
        });
    }
};
