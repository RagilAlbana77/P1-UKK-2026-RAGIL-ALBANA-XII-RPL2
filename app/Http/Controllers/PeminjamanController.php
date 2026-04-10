<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Services\PeminjamanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class PeminjamanController extends Controller
{
    public function __construct(
        private readonly PeminjamanService $peminjamanService
    ) {
    }

    public function index(Request $request): View
    {
        $query = Peminjaman::with(['user', 'alat'])->latest();

        if (! $request->user()?->isAdminOrPetugas()) {
            $query->where('user_id', $request->user()->id);
        }

        return view('peminjaman.index', [
            'peminjaman' => $query->paginate(10),
        ]);
    }

    public function approvalPage(Request $request): View
    {
        $this->authorizeAdminOrPetugas($request);

        return view('peminjaman.approval', [
            'peminjaman' => Peminjaman::with(['user', 'alat'])
                ->where('status', Peminjaman::STATUS_PENDING)
                ->latest()
                ->paginate(10),
        ]);
    }

    public function pengembalianPage(Request $request): View
    {
        $this->authorizeAdminOrPetugas($request);

        return view('peminjaman.pengembalian', [
            'peminjaman' => Peminjaman::with(['user', 'alat'])
                ->where('status', Peminjaman::STATUS_DIPINJAM)
                ->latest()
                ->paginate(10),
        ]);
    }

    public function riwayatPage(Request $request): View
    {
        return view('peminjaman.riwayat', [
            'peminjaman' => Peminjaman::with(['alat'])
                ->where('user_id', $request->user()->id)
                ->latest()
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('peminjaman.create', [
            'alat' => $this->availableAlat(true),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        return $this->runSafely(
            function () use ($request): RedirectResponse {
                $validated = $request->validate($this->borrowingRules());
                $this->peminjamanService->create($validated, $request->user()->id);

                return redirect()
                    ->route('peminjaman.index')
                    ->with('success', 'Pengajuan peminjaman berhasil dibuat.');
            },
            'Gagal membuat pengajuan peminjaman. Silakan coba lagi.',
            true
        );
    }

    public function show(Peminjaman $peminjaman): View
    {
        return view('peminjaman.show', [
            'peminjaman' => $peminjaman->load(['user', 'alat']),
        ]);
    }

    public function edit(Request $request, Peminjaman $peminjaman): View
    {
        $this->authorizeUserOrAdmin($request, $peminjaman);

        abort_unless($peminjaman->isPending(), 422, 'Hanya transaksi pending yang bisa diubah.');

        return view('peminjaman.edit', [
            'peminjaman' => $peminjaman,
            'alat' => $this->availableAlat(),
        ]);
    }

    public function update(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        $this->authorizeUserOrAdmin($request, $peminjaman);
        abort_unless($peminjaman->isPending(), 422, 'Hanya transaksi pending yang bisa diubah.');

        return $this->runSafely(
            function () use ($request, $peminjaman): RedirectResponse {
                $validated = $request->validate($this->borrowingRules());
                $this->peminjamanService->update($peminjaman, $validated);

                return redirect()
                    ->route('peminjaman.index')
                    ->with('success', 'Data peminjaman berhasil diperbarui.');
            },
            'Gagal memperbarui data peminjaman. Silakan coba lagi.',
            true
        );
    }

    public function destroy(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        $this->authorizeUserOrAdmin($request, $peminjaman);

        abort_unless($peminjaman->isPending(), 422, 'Hanya transaksi pending yang bisa dihapus.');

        $peminjaman->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function approve(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        $this->authorizeAdminOrPetugas($request);
        abort_unless($peminjaman->isPending(), 422, 'Status transaksi tidak valid untuk approval.');

        return $this->runSafely(
            function () use ($peminjaman): RedirectResponse {
                $this->peminjamanService->approve($peminjaman);

                return back()->with('success', 'Peminjaman disetujui.');
            },
            'Gagal menyetujui peminjaman. Silakan coba lagi.'
        );
    }

    public function reject(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        $this->authorizeAdminOrPetugas($request);
        abort_unless($peminjaman->isPending(), 422, 'Status transaksi tidak valid untuk penolakan.');

        return $this->runSafely(
            function () use ($request, $peminjaman): RedirectResponse {
                $this->peminjamanService->reject($peminjaman, $request->input('catatan'));

                return back()->with('success', 'Peminjaman ditolak.');
            },
            'Gagal menolak peminjaman. Silakan coba lagi.'
        );
    }

    public function kembalikan(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        $this->authorizeAdminOrPetugas($request);
        abort_unless($peminjaman->isDipinjam(), 422, 'Hanya transaksi dipinjam yang bisa dikembalikan.');

        return $this->runSafely(
            function () use ($peminjaman): RedirectResponse {
                $this->peminjamanService->processReturn($peminjaman);

                return back()->with('success', 'Pengembalian alat berhasil diproses.');
            },
            'Gagal memproses pengembalian. Silakan coba lagi.'
        );
    }

    private function authorizeAdminOrPetugas(Request $request): void
    {
        abort_unless($request->user()?->isAdminOrPetugas(), 403, 'Akses ditolak.');
    }

    private function authorizeUserOrAdmin(Request $request, Peminjaman $peminjaman): void
    {
        $isOwner = $request->user()?->id === $peminjaman->user_id;
        $isAdminOrPetugas = $request->user()?->isAdminOrPetugas();

        abort_unless($isOwner || $isAdminOrPetugas, 403, 'Akses ditolak.');
    }

    private function availableAlat(bool $onlyWithStock = false)
    {
        $query = Alat::query()
            ->where('status_ketersediaan', true)
            ->orderBy('nama_alat');

        if ($onlyWithStock) {
            $query->where('stok_tersedia', '>', 0);
        }

        return $query->get();
    }

    private function borrowingRules(): array
    {
        return [
            'alat_id' => ['required', 'exists:alat,id'],
            'qty' => ['required', 'integer', 'min:1'],
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_rencana_kembali' => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
            'catatan' => ['nullable', 'string'],
        ];
    }

    private function runSafely(callable $callback, string $errorMessage, bool $withInput = false): RedirectResponse
    {
        try {
            return $callback();
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error($errorMessage, [
                'message' => $e->getMessage(),
                'class' => static::class,
                'trace' => $e->getTraceAsString(),
            ]);

            $redirect = back();
            if ($withInput) {
                $redirect = $redirect->withInput();
            }

            return $redirect->withErrors([
                'system' => $errorMessage,
            ]);
        }
    }
}
