<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('alat.index', [
            'alat' => Alat::latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorizeAdmin($request);

        return view('alat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin($request);

        return $this->runSafely(
            function () use ($request): RedirectResponse {
                $validated = $request->validate($this->alatRules());

                $validated['status_ketersediaan'] = (bool) ($validated['status_ketersediaan'] ?? true);
                $validated['stok_tersedia'] = $validated['stok_total'];
                $validated['foto'] = $this->storeFoto($request);
                Alat::create($validated);

                return redirect()->route('alat.index')->with('success', 'Data alat berhasil ditambahkan.');
            },
            'Gagal menambahkan data alat.',
            true
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Alat $alat): View
    {
        return view('alat.show', compact('alat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Alat $alat): View
    {
        $this->authorizeAdmin($request);

        return view('alat.edit', compact('alat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alat $alat): RedirectResponse
    {
        $this->authorizeAdmin($request);

        return $this->runSafely(
            function () use ($request, $alat): RedirectResponse {
                $validated = $request->validate($this->alatRules($alat->id));
                $validated['stok_tersedia'] = $this->calculateUpdatedStokTersedia($alat, $validated['stok_total']);

                $validated['status_ketersediaan'] = (bool) ($validated['status_ketersediaan'] ?? false);
                $validated['foto'] = $this->storeFoto($request, $alat->foto);
                $alat->update($validated);

                return redirect()->route('alat.index')->with('success', 'Data alat berhasil diperbarui.');
            },
            'Gagal memperbarui data alat.',
            true
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Alat $alat): RedirectResponse
    {
        $this->authorizeAdmin($request);

        if ($alat->peminjaman()->whereIn('status', [Peminjaman::STATUS_PENDING, Peminjaman::STATUS_DIPINJAM])->exists()) {
            return redirect()->route('alat.index')->withErrors([
                'alat' => 'Alat tidak bisa dihapus karena masih punya transaksi aktif.',
            ]);
        }

        if (! empty($alat->foto) && Storage::disk('public')->exists($alat->foto)) {
            Storage::disk('public')->delete($alat->foto);
        }

        $alat->delete();

        return redirect()->route('alat.index')->with('success', 'Data alat berhasil dihapus.');
    }

    private function authorizeAdmin(Request $request): void
    {
        abort_unless($request->user()?->role === 'admin', 403, 'Akses ditolak.');
    }

    private function alatRules(?int $alatId = null): array
    {
        $uniqueRule = 'unique:alat,kode_alat';
        if ($alatId !== null) {
            $uniqueRule .= ',' . $alatId;
        }

        return [
            'kode_alat' => ['required', 'string', 'max:50', $uniqueRule],
            'nama_alat' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:Elektronik,Multimedia,Audio,Umum'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'stok_total' => ['required', 'integer', 'min:0'],
            'kondisi' => ['required', 'in:baik,rusak_ringan,rusak'],
            'status_ketersediaan' => ['nullable', 'boolean'],
        ];
    }

    private function calculateUpdatedStokTersedia(Alat $alat, int $newStokTotal): int
    {
        $currentlyBorrowed = max($alat->stok_total - $alat->stok_tersedia, 0);

        if ($newStokTotal < $currentlyBorrowed) {
            throw ValidationException::withMessages([
                'stok_total' => "Stok total tidak boleh lebih kecil dari jumlah yang sedang dipinjam ({$currentlyBorrowed}).",
            ]);
        }

        return $newStokTotal - $currentlyBorrowed;
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

    private function storeFoto(Request $request, ?string $oldPath = null): ?string
    {
        if (! $request->hasFile('foto')) {
            return $oldPath;
        }

        if (! empty($oldPath) && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        return $request->file('foto')->store('alat', 'public');
    }
}
