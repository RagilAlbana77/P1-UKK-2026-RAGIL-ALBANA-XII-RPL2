<?php

namespace App\Services;

use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PeminjamanService
{
    public function create(array $validated, int $userId): Peminjaman
    {
        $alat = Alat::findOrFail($validated['alat_id']);
        $this->validateStock($validated['qty'], $alat->stok_tersedia);

        return Peminjaman::create([
            'user_id' => $userId,
            'alat_id' => $validated['alat_id'],
            'qty' => $validated['qty'],
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_rencana_kembali' => $validated['tanggal_rencana_kembali'],
            'status' => Peminjaman::STATUS_PENDING,
            'catatan' => $validated['catatan'] ?? null,
        ]);
    }

    public function update(Peminjaman $peminjaman, array $validated): void
    {
        $alat = Alat::findOrFail($validated['alat_id']);
        $this->validateStock($validated['qty'], $alat->stok_tersedia);

        $peminjaman->update($validated);
    }

    public function approve(Peminjaman $peminjaman): void
    {
        DB::transaction(function () use ($peminjaman): void {
            $alat = Alat::lockForUpdate()->findOrFail($peminjaman->alat_id);
            $this->validateStock($peminjaman->qty, $alat->stok_tersedia);

            $alat->decrement('stok_tersedia', $peminjaman->qty);
            $peminjaman->update(['status' => Peminjaman::STATUS_DIPINJAM]);
        });
    }

    public function reject(Peminjaman $peminjaman, ?string $catatan): void
    {
        $peminjaman->update([
            'status' => Peminjaman::STATUS_REJECTED,
            'catatan' => $catatan ?? $peminjaman->catatan,
        ]);
    }

    public function processReturn(Peminjaman $peminjaman): void
    {
        DB::transaction(function () use ($peminjaman): void {
            $alat = Alat::lockForUpdate()->findOrFail($peminjaman->alat_id);

            $alat->increment('stok_tersedia', $peminjaman->qty);
            $peminjaman->update([
                'status' => Peminjaman::STATUS_DIKEMBALIKAN,
                'tanggal_kembali' => now()->toDateString(),
            ]);
        });
    }

    private function validateStock(int $qty, int $stokTersedia): void
    {
        if ($qty > $stokTersedia) {
            throw ValidationException::withMessages([
                'qty' => 'Jumlah peminjaman melebihi stok tersedia.',
            ]);
        }
    }
}
