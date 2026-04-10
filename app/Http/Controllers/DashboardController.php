<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private const DENDA_PER_HARI = 5000;

    public function index(): View
    {
        $user = auth()->user();

        if ($user?->role === 'petugas') {
            return $this->petugasDashboard();
        }

        if ($user?->role === 'peminjam') {
            return $this->peminjamDashboard();
        }

        return $this->adminDashboard();
    }

    private function adminDashboard(): View
    {
        $totalAlat = Alat::count();
        $alatDipinjam = (int) Peminjaman::where('status', Peminjaman::STATUS_DIPINJAM)->sum('qty');
        $alatTersedia = (int) Alat::sum('stok_tersedia');
        $totalDenda = $this->calculateTotalDenda();

        $latestPeminjaman = Peminjaman::with(['user', 'alat'])->latest()->limit(8)->get();

        return view('dashboard', compact(
            'totalAlat',
            'alatDipinjam',
            'alatTersedia',
            'totalDenda',
            'latestPeminjaman'
        ));
    }

    private function calculateTotalDenda(): int
    {
        $today = now()->startOfDay();

        return Peminjaman::query()
            ->whereIn('status', [Peminjaman::STATUS_DIPINJAM, Peminjaman::STATUS_DIKEMBALIKAN])
            ->whereNotNull('tanggal_rencana_kembali')
            ->get()
            ->sum(function (Peminjaman $peminjaman) use ($today): int {
                $dueDate = $peminjaman->tanggal_rencana_kembali?->copy()->startOfDay();
                if (! $dueDate) {
                    return 0;
                }

                $endDate = $peminjaman->status === Peminjaman::STATUS_DIKEMBALIKAN
                    ? $peminjaman->tanggal_kembali?->copy()->startOfDay()
                    : $today;

                if (! $endDate || $endDate->lessThanOrEqualTo($dueDate)) {
                    return 0;
                }

                $lateDays = $dueDate->diffInDays($endDate);

                return $lateDays * self::DENDA_PER_HARI * max((int) $peminjaman->qty, 1);
            });
    }

    private function petugasDashboard(): View
    {
        $pending = Peminjaman::with(['user', 'alat'])->where('status', Peminjaman::STATUS_PENDING)->latest()->limit(8)->get();
        $perluPengembalian = Peminjaman::with(['user', 'alat'])->where('status', Peminjaman::STATUS_DIPINJAM)->latest()->limit(8)->get();

        return view('dashboard_petugas', [
            'pending' => $pending,
            'perluPengembalian' => $perluPengembalian,
            'totalPending' => $pending->count(),
            'totalPengembalian' => $perluPengembalian->count(),
        ]);
    }

    private function peminjamDashboard(): View
    {
        $userId = auth()->id();

        $alat = Alat::where('status_ketersediaan', true)->where('stok_tersedia', '>', 0)->latest()->paginate(12);
        $riwayat = Peminjaman::with('alat')->where('user_id', $userId)->latest()->limit(5)->get();

        $totalTersedia = (int) Alat::where('status_ketersediaan', true)->sum('stok_tersedia');
        $sedangDipinjam = (int) Peminjaman::where('user_id', $userId)
            ->where('status', Peminjaman::STATUS_DIPINJAM)
            ->sum('qty');
        $perluKembali = Peminjaman::where('user_id', $userId)
            ->where('status', Peminjaman::STATUS_DIPINJAM)
            ->whereDate('tanggal_rencana_kembali', '<', now()->toDateString())
            ->count();
        $permintaanAktif = Peminjaman::where('user_id', $userId)
            ->where('status', Peminjaman::STATUS_PENDING)
            ->count();

        return view('dashboard_peminjam', [
            'alat' => $alat,
            'riwayat' => $riwayat,
            'totalTersedia' => $totalTersedia,
            'sedangDipinjam' => $sedangDipinjam,
            'perluKembali' => $perluKembali,
            'permintaanAktif' => $permintaanAktif,
        ]);
    }
}
