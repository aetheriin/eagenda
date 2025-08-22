<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\MemorandumKeluarController;
use App\Http\Controllers\Master\NaskahMasukController;
use App\Http\Controllers\Master\BelanjaKeluarController;
use App\Http\Controllers\Master\KeamananSuratController;
use App\Http\Controllers\Master\KlasifikasiNaskahController;
use App\Http\Controllers\Master\SuratTugasController;
use App\Http\Controllers\Master\SuratDinasController;
use App\Http\Controllers\Master\UndanganInternalController;
use App\Http\Controllers\Master\UndanganEksternalController;
use App\Http\Controllers\Master\SopKeluarController;
use App\Http\Controllers\Master\BagianFungsiController;
use App\Http\Controllers\Master\SubTimController;
use App\Http\Controllers\UserController;
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

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/profile/admin', function () {
    return view('profile.admin'); 
})->middleware(['auth'])->name('profile.admin');

Route::get('/profile/edit', function () {
    return view('profile.edit'); 
})->middleware(['auth'])->name('profile.edit');


Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // ✅ Kelola Akun
    Route::resource('users', UserController::class);

    
    // Master
    Route::resource('keamanan-surat', KeamananSuratController::class);
    Route::resource('klasifikasi-naskah', KlasifikasiNaskahController::class);
    Route::resource('klasifikasi-naskah ', \App\Http\Controllers\Master\KlasifikasiNaskahController::class);
    Route::resource('bagian-fungsi', BagianFungsiController::class);
    Route::resource('sub-tim', SubTimController::class);



    // Naskah Masuk
    Route::resource('naskah-masuk', NaskahMasukController::class);
    Route::resource('naskahmasuk', \App\Http\Controllers\Master\NaskahMasukController::class);

    // Naskah Keluar 
    Route::resource('memorandum-keluar', MemorandumKeluarController::class);
    Route::resource('belanja-keluar', BelanjaKeluarController::class);
    Route::resource('surat-tugas', SuratTugasController::class);
    Route::resource('surat-dinas', SuratDinasController::class);
    Route::resource('undangan-internal', UndanganInternalController::class);
    Route::resource('undangan-eksternal', UndanganEksternalController::class);
    Route::resource('sop-keluar', SopKeluarController::class);

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        // ✅ Naskah Masuk
        Route::get('naskah-masuk', [LaporanController::class, 'naskahMasuk'])
            ->name('naskah-masuk');

        Route::get('naskah-masuk/export', [LaporanController::class, 'exportNaskahMasuk'])
            ->name('naskah-masuk.export');

        // ✅ Naskah Keluar
        Route::get('naskah-keluar', [LaporanController::class, 'naskahKeluar'])
            ->name('naskah-keluar');
        
        Route::get('{jenis}/export', [LaporanController::class, 'exportNaskahKeluar'])
            ->name('naskah-keluar.export');
    });

});

// Override login POST (custom tahun)
Route::post('/login', [CustomAuthenticatedSessionController::class, 'store'])
    ->middleware(['guest'])
    ->name('login');

require __DIR__.'/auth.php';
