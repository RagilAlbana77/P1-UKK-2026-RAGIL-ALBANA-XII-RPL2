<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

// API endpoints (opsional) untuk integrasi mobile/SPA.
// Jika ingin full API auth, aktifkan Sanctum dan ganti middleware sesuai kebutuhan.
Route::name('api.')->group(function (): void {
    Route::get('/alat', [AlatController::class, 'index'])->name('alat.index');

    Route::middleware('auth')->group(function (): void {
        Route::apiResource('peminjaman', PeminjamanController::class)->names([
            'index' => 'peminjaman.index',
            'store' => 'peminjaman.store',
            'show' => 'peminjaman.show',
            'update' => 'peminjaman.update',
            'destroy' => 'peminjaman.destroy',
        ]);

        Route::post('/peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
        Route::post('/peminjaman/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
        Route::post('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    });
});
