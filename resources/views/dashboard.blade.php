@extends('layouts.stitch')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold font-manrope text-[#001535]">Dashboard Utama</h2>
        <p class="text-[#44474E]">Monitor status peminjaman alat secara real-time.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <x-stitch.kpi-card label="Total Alat" :value="$totalAlat" icon="inventory" hint="Total item inventaris" />
        <x-stitch.kpi-card label="Alat Dipinjam" :value="$alatDipinjam" icon="outbox" accent="#325F9E" hint="Sedang dipinjam" />
        <x-stitch.kpi-card label="Alat Tersedia" :value="$alatTersedia" icon="check_circle" accent="#0098EE" hint="Siap dipinjam" />
        <x-stitch.kpi-card label="Total Denda" :value="'Rp ' . number_format($totalDenda, 0, ',', '.')" icon="payments" accent="#BA1A1A" hint="Akumulasi denda keterlambatan" />
    </div>

    <div class="stitch-card p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold font-manrope text-[#001535]">Peminjaman Terbaru</h3>
            <a href="{{ route('peminjaman.index') }}" class="text-sm font-semibold text-[#2DA8FF]">Lihat semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-[11px] uppercase tracking-widest text-gray-500 border-b">
                        <th class="py-3">Peminjam</th>
                        <th class="py-3">Alat</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestPeminjaman as $item)
                        <tr class="border-b last:border-0">
                            <td class="py-3">{{ $item->user->name }}</td>
                            <td class="py-3">{{ $item->alat->nama_alat }}</td>
                            <td class="py-3">{{ $item->tanggal_pinjam->format('d M Y') }}</td>
                            <td class="py-3">
                                <span class="stitch-badge {{ $item->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($item->status === 'dipinjam' ? 'bg-blue-100 text-blue-700' : ($item->status === 'dikembalikan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700')) }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-6 text-center text-gray-500">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
