@extends('layouts.stitch')

@section('content')
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold font-manrope text-[#001535]">Data Peminjaman</h2>
            <p class="text-[#44474E]">Flow pengajuan, approval, dan pengembalian alat.</p>
        </div>
        <a href="{{ route('peminjaman.create') }}" class="stitch-btn-primary inline-flex items-center gap-2">
            <span class="material-symbols-outlined">add</span>
            Ajukan Peminjaman
        </a>
    </div>

    <div class="stitch-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-[#F4F3F7] text-[11px] uppercase tracking-widest text-gray-600">
                        <th class="px-5 py-4 text-left">Peminjam</th>
                        <th class="px-5 py-4 text-left">Alat</th>
                        <th class="px-5 py-4 text-left">Qty</th>
                        <th class="px-5 py-4 text-left">Tanggal</th>
                        <th class="px-5 py-4 text-left">Status</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjaman as $item)
                        <tr class="border-b last:border-0 hover:bg-[#FAF9FD]">
                            <td class="px-5 py-4">{{ $item->user->name }}</td>
                            <td class="px-5 py-4">{{ $item->alat->nama_alat }}</td>
                            <td class="px-5 py-4">{{ $item->qty }}</td>
                            <td class="px-5 py-4">{{ $item->tanggal_pinjam->format('d M Y') }}</td>
                            <td class="px-5 py-4">
                                <span class="stitch-badge {{ $item->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($item->status === 'dipinjam' ? 'bg-blue-100 text-blue-700' : ($item->status === 'dikembalikan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700')) }}">{{ $item->status }}</span>
                            </td>
                            <td class="px-5 py-4 text-right space-x-2">
                                <a href="{{ route('peminjaman.show', $item) }}" class="text-blue-600">Detail</a>
                                @if ($item->status === 'pending')
                                    <a href="{{ route('peminjaman.edit', $item) }}" class="text-amber-600">Edit</a>
                                @endif

                                @if (auth()->user()->isAdminOrPetugas() && $item->status === 'pending')
                                    <form class="inline" method="POST" action="{{ route('peminjaman.approve', $item) }}">@csrf<button type="submit" class="text-green-700">Approve</button></form>
                                    <form class="inline" method="POST" action="{{ route('peminjaman.reject', $item) }}">@csrf<button type="submit" class="text-red-700">Reject</button></form>
                                @endif

                                @if (auth()->user()->isAdminOrPetugas() && $item->status === 'dipinjam')
                                    <form class="inline" method="POST" action="{{ route('peminjaman.kembalikan', $item) }}">@csrf<button type="submit" class="text-purple-700">Kembalikan</button></form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-8 text-center text-gray-500">Belum ada transaksi peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $peminjaman->links() }}</div>
@endsection
