<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});
//
require __DIR__.'/auth.php';

// Redirect root ke login
Route::redirect('/','login');

// Auth route (Breeze)
Route::middleware('guest')->group(function () {
    Route::get('login',[AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login',[AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    // Logout
    Route::get('logout',[AuthenticatedSessionController::class, 'destroy'])->name('logout');


    // Group per role
    Route::prefix('bapendik')->middleware(['auth','role:bapendik'])->group(function () {
        Route::get('/dashboard', function () {
            return view('bapendik.dashboard');
        })->name('dashboard.bapendik');

        // Tambah disini
    });

    Route::prefix('mahasiswa')->middleware(['auth','role:mahasiswa'])->group(function () {
        Route::get('/dashboard', function () {
            return view('mahasiswa.dashboard');
        })->name('dashboard.mahasiswa');

        // Tambah disini
    });

    Route::prefix('dosen-pembimbing')->middleware(['auth','role:dosen_pembimbing'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dosen_pembimbing.dashboard');
        })->name('dashboard.dosen_pembimbing');

        // Tambah disini
    });

    Route::prefix('dosen-komisi')->middleware(['auth','role:dosen_komisi'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dosen-komisi.dashboard');
        })->name('dashboard.dosen_komisi');

        // Tambah disini
    });

});
