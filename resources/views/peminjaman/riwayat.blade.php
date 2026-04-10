@extends('layouts.stitch')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-extrabold font-manrope text-[#001535]">Riwayat Peminjaman</h2>
    <p class="text-[#44474E]">Riwayat transaksi peminjam.</p>
</div>

<div class="stitch-card overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-[#F4F3F7] text-[11px] uppercase tracking-widest text-gray-600">
                <th class="px-5 py-4 text-left">ID</th>
                <th class="px-5 py-4 text-left">Alat</th>
                <th class="px-5 py-4 text-left">Tanggal Pinjam</th>
                <th class="px-5 py-4 text-left">Status</th>
                <th class="px-5 py-4 text-left">Tanggal Kembali</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjaman as $row)
                <tr class="border-b last:border-0">
                    <td class="px-5 py-4">#{{ $row->id }}</td>
                    <td class="px-5 py-4">{{ $row->alat->nama_alat }}</td>
                    <td class="px-5 py-4">{{ $row->tanggal_pinjam->format('d M Y') }}</td>
                    <td class="px-5 py-4">{{ $row->status }}</td>
                    <td class="px-5 py-4">{{ $row->tanggal_kembali?->format('d M Y') ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500">Belum ada riwayat.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $peminjaman->links() }}</div>
@endsection
