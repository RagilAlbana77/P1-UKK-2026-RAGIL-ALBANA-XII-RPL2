<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    if (Auth::check()) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('peminjaman', PeminjamanController::class);

    Route::get('/alat', [AlatController::class, 'index'])->name('alat.index');

    Route::middleware('role:admin')->group(function () {
        Route::get('/alat/create', [AlatController::class, 'create'])->name('alat.create');
        Route::post('/alat', [AlatController::class, 'store'])->name('alat.store');
        Route::get('/alat/{alat}/edit', [AlatController::class, 'edit'])->name('alat.edit');
        Route::put('/alat/{alat}', [AlatController::class, 'update'])->name('alat.update');
        Route::patch('/alat/{alat}', [AlatController::class, 'update']);
        Route::delete('/alat/{alat}', [AlatController::class, 'destroy'])->name('alat.destroy');

        Route::resource('users', UserManagementController::class);
        Route::get('/peminjam', [UserManagementController::class, 'index'])
            ->name('users.peminjam')
            ->defaults('role', 'peminjam');
    });
    Route::get('/alat/{alat}', [AlatController::class, 'show'])->name('alat.show');

    Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'riwayatPage'])->name('peminjaman.riwayat');

    Route::middleware('role:admin,petugas')->group(function () {
        Route::get('/peminjaman-approval', [PeminjamanController::class, 'approvalPage'])->name('peminjaman.approval');
        Route::get('/peminjaman-pengembalian', [PeminjamanController::class, 'pengembalianPage'])->name('peminjaman.pengembalian');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity.index');
        Route::post('/peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
        Route::post('/peminjaman/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
        Route::post('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    });
});

require __DIR__.'/auth.php';
