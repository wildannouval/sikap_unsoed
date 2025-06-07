<?php

use App\Http\Controllers\Bapendik\JurusanController;
use App\Http\Controllers\Bapendik\PenggunaController;
use App\Http\Controllers\Bapendik\ValidasiSuratController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Mahasiswa\SuratPengantarController;

//Route::get('/', function () {
//    return view('welcome');
//});
//
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ROUTE BARU UNTUK MELIHAT SEMUA JADWAL SEMINAR FINAL
    Route::get('/jadwal-seminar-terpublikasi', [\App\Http\Controllers\JadwalSeminarPublikController::class, 'index'])->name('jadwal-seminar.publik.index');
});

require __DIR__.'/auth.php';

// Redirect root ke login


// Auth route (Breeze)
Route::middleware('guest')->group(function () {
    Route::redirect('/','login');
    Route::get('login',[AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login',[AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    // Logout
    Route::get('logout',[AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Route untuk '/', jika pengguna sudah login, arahkan ke dashboard masing-masing
    Route::get('/', function () {
        $role = strtolower(Auth::user()->role);
        return match($role) {
            'bapendik' => redirect()->route('bapendik.dashboard'),
            'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
            'dosen_pembimbing' => redirect()->route('dosen-pembimbing.dashboard'),
            'dosen_komisi' => redirect()->route('dosen-komisi.dashboard'),
            default => redirect()->route('login'), // Fallback jika ada masalah
        };
    })->name('home');

    // Group per role
    Route::prefix('bapendik')->middleware(['auth','role:bapendik'])->name('bapendik.')->group(function () {
//        Route::get('/dashboard', function () {
//            return view('bapendik.dashboard');
//        })->name('dashboard');
        Route::get('/dashboard', [\App\Http\Controllers\Bapendik\DashboardController::class, 'index'])->name('dashboard');

        // Fitur Juragan
        Route::resource('jurusan',JurusanController::class);

        // Fitur Pengguna
        Route::resource('pengguna', PenggunaController::class);

        // TAMBAHKAN ROUTE RESOURCE INI UNTUK VALIDASI SURAT PENGANTAR
        // Kita hanya akan menggunakan method index, edit, dan update dari resource ini
        Route::resource('validasi-surat', ValidasiSuratController::class)->only([
            'index', 'edit', 'update'
        ])->parameters(['validasi-surat' => 'suratPengantar']); // Mengganti nama parameter route model binding

        // TAMBAHKAN ROUTE INI UNTUK EXPORT WORD
        Route::get('validasi-surat/{suratPengantar}/export-word', [\App\Http\Controllers\Bapendik\ValidasiSuratController::class, 'exportWord'])
            ->name('validasi-surat.exportWord');

        // ROUTE BARU UNTUK MANAJEMEN SPK
//        Route::get('spk', [\App\Http\Controllers\Bapendik\SpkController::class, 'index'])->name('spk.index');
//        Route::get('spk/{pengajuanKp}/export-word', [\App\Http\Controllers\Bapendik\SpkController::class, 'exportSpkWord'])->name('spk.exportWord');

        // GANTI DENGAN INI:
        Route::resource('spk', \App\Http\Controllers\Bapendik\SpkController::class)->only([
            'index', 'edit', 'update'
        ])->parameters(['spk' => 'pengajuanKp']); // Mengganti nama parameter

        Route::get('spk/{pengajuanKp}/export-word', [\App\Http\Controllers\Bapendik\SpkController::class, 'exportSpkWord'])
            ->name('spk.exportWord');

        // ROUTE BARU/PENYESUAIAN UNTUK PENJADWALAN SEMINAR OLEH BAPENDIK
        Route::get('/penjadwalan-seminar', [\App\Http\Controllers\Bapendik\PenjadwalanSeminarController::class, 'index'])
            ->name('penjadwalan-seminar.index');
        Route::get('/penjadwalan-seminar/{seminar}/tetapkan-jadwal', [\App\Http\Controllers\Bapendik\PenjadwalanSeminarController::class, 'editJadwal'])
            ->name('penjadwalan-seminar.editJadwal');
        Route::put('/penjadwalan-seminar/{seminar}/simpan-jadwal', [\App\Http\Controllers\Bapendik\PenjadwalanSeminarController::class, 'updateJadwal'])
            ->name('penjadwalan-seminar.updateJadwal');
        // TAMBAHKAN ROUTE BARU INI UNTUK MEMBATALKAN SEMINAR
        Route::post('penjadwalan-seminar/{seminar}/cancel', [\App\Http\Controllers\Bapendik\PenjadwalanSeminarController::class, 'cancel'])
            ->name('penjadwalan-seminar.cancel');

        // TAMBAHKAN ROUTE INI UNTUK EXPORT DOKUMEN SEMINAR
        Route::get('/penjadwalan-seminar/{seminar}/export-berita-acara', [\App\Http\Controllers\Bapendik\PenjadwalanSeminarController::class, 'exportBeritaAcaraWord'])
            ->name('penjadwalan-seminar.exportBeritaAcaraWord');

        // CRUD Ruangan Seminar
        Route::resource('ruangan', \App\Http\Controllers\Bapendik\RuanganController::class);

    });

    Route::prefix('mahasiswa')->middleware(['auth','role:mahasiswa'])->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Mahasiswa\DashboardController::class, 'index'])->name('dashboard');

        // Route untuk Surat Pengantar Mahasiswa
        Route::get('/surat-pengantar', [SuratPengantarController::class, 'index'])->name('surat-pengantar.index');
        Route::get('/surat-pengantar/create', [SuratPengantarController::class, 'create'])->name('surat-pengantar.create');
        Route::post('/surat-pengantar', [SuratPengantarController::class, 'store'])->name('surat-pengantar.store');
        // Jika ada route show untuk pengajuan KP, bisa ditambahkan di sini atau nanti
        // Route::get('/pengajuan-kp/{pengajuanKp}', [\App\Http\Controllers\Mahasiswa\PengajuanKpController::class, 'show'])->name('pengajuan-kp.show');

        // TAMBAHKAN ROUTE BARU UNTUK PENGAJUAN KP
        Route::get('/pengajuan-kp', [\App\Http\Controllers\Mahasiswa\PengajuanKpController::class, 'index'])->name('pengajuan-kp.index');
        Route::get('/pengajuan-kp/create', [\App\Http\Controllers\Mahasiswa\PengajuanKpController::class, 'create'])->name('pengajuan-kp.create');
        Route::post('/pengajuan-kp', [\App\Http\Controllers\Mahasiswa\PengajuanKpController::class, 'store'])->name('pengajuan-kp.store');
        // Jika nanti butuh melihat detail pengajuan KP oleh mahasiswa:
        // Route::get('/pengajuan-kp/{pengajuanKp}', [\App\Http\Controllers\Mahasiswa\PengajuanKpController::class, 'show'])->name('pengajuan-kp.show');

        // Route untuk Konsultasi KP
        Route::get('/pengajuan-kp/{pengajuanKp}/konsultasi', [\App\Http\Controllers\Mahasiswa\KonsultasiKpController::class, 'index'])
            ->name('pengajuan-kp.konsultasi.index');
        Route::get('/pengajuan-kp/{pengajuanKp}/konsultasi/create', [\App\Http\Controllers\Mahasiswa\KonsultasiKpController::class, 'create'])
            ->name('pengajuan-kp.konsultasi.create');
        Route::post('/pengajuan-kp/{pengajuanKp}/konsultasi', [\App\Http\Controllers\Mahasiswa\KonsultasiKpController::class, 'store'])
            ->name('pengajuan-kp.konsultasi.store');

        // ROUTE BARU/PENYESUAIAN UNTUK PENGAJUAN SEMINAR
        Route::get('/pengajuan-kp/{pengajuanKp}/seminar/create', [\App\Http\Controllers\Mahasiswa\SeminarKpController::class, 'create'])
            ->name('pengajuan-kp.seminar.create');
        Route::post('/pengajuan-kp/{pengajuanKp}/seminar', [\App\Http\Controllers\Mahasiswa\SeminarKpController::class, 'store'])
            ->name('pengajuan-kp.seminar.store');

        Route::get('/seminar', [\App\Http\Controllers\Mahasiswa\SeminarKpController::class, 'index'])
            ->name('seminar.index'); // Untuk mahasiswa melihat daftar/status seminarnya

        // ROUTE BARU UNTUK UPLOAD BUKTI DISTRIBUSI LAPORAN (NESTED DI BAWAH PENGAJUAN KP)
//        Route::get('/pengajuan-kp/{pengajuanKp}/distribusi/create', [\App\Http\Controllers\Mahasiswa\DistribusiLaporanController::class, 'create'])
//            ->name('pengajuan-kp.distribusi.create');
//        Route::post('/pengajuan-kp/{pengajuanKp}/distribusi', [\App\Http\Controllers\Mahasiswa\DistribusiLaporanController::class, 'store'])
//            ->name('pengajuan-kp.distribusi.store');

        // Opsional: Jika mahasiswa perlu melihat detail bukti distribusi yang sudah diupload
        // Route::get('/pengajuan-kp/{pengajuanKp}/distribusi', [\App\Http\Controllers\Mahasiswa\DistribusiLaporanController::class, 'show'])
        //     ->name('pengajuan-kp.distribusi.show');

        // ROUTE DISTRIBUSI LAPORAN
        Route::get('/distribusi-laporan', [\App\Http\Controllers\Mahasiswa\DistribusiLaporanController::class, 'index'])
            ->name('distribusi-laporan.index'); // Halaman daftar KP yang siap/sudah distribusi
        // Route create dan store bisa tetap nested di pengajuan KP atau dibuat terpisah
        // Jika tetap nested, tombol di halaman index distribusi akan mengarah ke sini
        Route::get('/pengajuan-kp/{pengajuanKp}/distribusi/create', [\App\Http\Controllers\Mahasiswa\DistribusiLaporanController::class, 'create'])
            ->name('pengajuan-kp.distribusi.create');
        Route::post('/pengajuan-kp/{pengajuanKp}/distribusi', [\App\Http\Controllers\Mahasiswa\DistribusiLaporanController::class, 'store'])
            ->name('pengajuan-kp.distribusi.store');

    });

    Route::prefix('dosen-pembimbing')->middleware(['auth','role:dosen_pembimbing'])->name('dosen-pembimbing.')->group(function () {
//        Route::get('/dashboard', function () {
//            return view('dosen-pembimbing.dashboard');
//        })->name('dashboard');
        Route::get('/dashboard', [\App\Http\Controllers\DosenPembimbing\DashboardController::class, 'index'])->name('dashboard');

        // ROUTE UNTUK MENAMPILKAN DAFTAR MAHASISWA BIMBINGAN KP
        Route::get('/bimbingan-kp', [\App\Http\Controllers\DosenPembimbing\BimbinganKpController::class, 'index'])
            ->name('bimbingan-kp.index');

        // ROUTE UNTUK MENAMPILKAN DAN MEMPROSES KONSULTASI UNTUK SATU PENGAJUAN KP
        Route::get('/bimbingan-kp/{pengajuanKp}/konsultasi', [\App\Http\Controllers\DosenPembimbing\KonsultasiKpController::class, 'showKonsultasi'])
            ->name('bimbingan-kp.konsultasi.show');

        Route::post('/konsultasi/{konsultasi}/verifikasi', [\App\Http\Controllers\DosenPembimbing\KonsultasiKpController::class, 'verifikasi'])
            ->name('konsultasi.verifikasi'); // Untuk menyimpan verifikasi dan catatan dosen

        // ROUTE BARU UNTUK PERSETUJUAN PENGAJUAN SEMINAR
        Route::get('/persetujuan-seminar', [\App\Http\Controllers\DosenPembimbing\SeminarApprovalController::class, 'index'])
            ->name('seminar-approval.index');
        Route::get('/persetujuan-seminar/{seminar}/proses', [\App\Http\Controllers\DosenPembimbing\SeminarApprovalController::class, 'showForm'])
            ->name('seminar-approval.showForm'); // Menggunakan 'showForm' agar tidak bentrok dengan 'show' jika ada nanti
        Route::post('/persetujuan-seminar/{seminar}', [\App\Http\Controllers\DosenPembimbing\SeminarApprovalController::class, 'processApproval'])
            ->name('seminar-approval.process');

        // ROUTE BARU UNTUK PENILAIAN SEMINAR KP
        Route::get('/penilaian-seminar', [\App\Http\Controllers\DosenPembimbing\PenilaianSeminarController::class, 'index'])
            ->name('penilaian-seminar.index');
        Route::get('/penilaian-seminar/{seminar}/input-hasil', [\App\Http\Controllers\DosenPembimbing\PenilaianSeminarController::class, 'editHasil'])
            ->name('penilaian-seminar.editHasil'); // Form untuk input nilai & BA
        Route::put('/penilaian-seminar/{seminar}/simpan-hasil', [\App\Http\Controllers\DosenPembimbing\PenilaianSeminarController::class, 'updateHasil'])
            ->name('penilaian-seminar.updateHasil'); // Menyimpan hasil penilaian
    });

    Route::prefix('dosen-komisi')->middleware(['auth','role:dosen_komisi'])->name('dosen-komisi.')->group(function () {
//        Route::get('/dashboard', function () {
//            return view('dosen-komisi.dashboard');
//        })->name('dashboard');
        Route::get('/dashboard', [\App\Http\Controllers\DosenKomisi\DashboardController::class, 'index'])->name('dashboard');

        // TAMBAHKAN ROUTE RESOURCE INI UNTUK VALIDASI PENGAJUAN KP
        // Kita akan menggunakan method index, edit, dan update
        Route::resource('validasi-kp', \App\Http\Controllers\DosenKomisi\ValidasiKpController::class)->only([
            'index', 'edit', 'update'
        ])->parameters(['validasi-kp' => 'pengajuanKp']); // Mengganti nama parameter route model binding
    });



});
