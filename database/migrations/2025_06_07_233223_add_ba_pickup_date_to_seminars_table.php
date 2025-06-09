<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seminars', function (Blueprint $table) {
            // Kolom untuk menyimpan tanggal kapan Berita Acara bisa diambil oleh mahasiswa
            $table->date('ba_tanggal_pengambilan')->nullable()->after('berita_acara_path');
        });
    }

    public function down(): void
    {
        Schema::table('seminars', function (Blueprint $table) {
            $table->dropColumn('ba_tanggal_pengambilan');
        });
    }
};
