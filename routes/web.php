<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Master\MemorandumKeluarController;
use App\Http\Controllers\Master\NaskahMasukController;
use App\Http\Controllers\Master\BelanjaKeluarController;
use App\Http\Controllers\Master\KeamananSuratController;
use App\Http\Controllers\Master\KlasifikasiNaskahController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Auth\CustomAuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Master
    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('bagian-fungsi', BagianFungsiController::class)->except(['show']);
        // tambah resource lain jika perlu
    });

    // Master
    Route::resource('keamanan-surat', KeamananSuratController::class);
    Route::resource('klasifikasi-naskah', KlasifikasiNaskahController::class);

    // Naskah Masuk
    Route::resource('naskah-masuk', NaskahMasukController::class);
    Route::resource('naskahmasuk', \App\Http\Controllers\Master\NaskahMasukController::class);

    // Naskah Keluar 
    Route::resource('memorandum-keluar', MemorandumKeluarController::class);
    Route::resource('belanja-keluar', BelanjaKeluarController::class);

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('ringkasan', [LaporanController::class, 'ringkasan'])->name('ringkasan');
        Route::get('export', [LaporanController::class, 'export'])->name('export');
        Route::get('filter', [LaporanController::class, 'filter'])->name('filter');
    });
});

// Override login POST (custom tahun)
Route::post('/login', [CustomAuthenticatedSessionController::class, 'store'])
    ->middleware(['guest'])
    ->name('login');

require __DIR__.'/auth.php';
