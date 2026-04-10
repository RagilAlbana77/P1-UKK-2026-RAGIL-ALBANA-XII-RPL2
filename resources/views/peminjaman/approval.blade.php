@extends('layouts.stitch')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-extrabold font-manrope text-[#001535]">Persetujuan Peminjaman</h2>
    <p class="text-[#44474E]">Daftar pengajuan menunggu persetujuan petugas/admin.</p>
</div>

<div class="stitch-card overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-[#F4F3F7] text-[11px] uppercase tracking-widest text-gray-600">
                <th class="px-5 py-4 text-left">Peminjam</th>
                <th class="px-5 py-4 text-left">Alat</th>
                <th class="px-5 py-4 text-left">Qty</th>
                <th class="px-5 py-4 text-left">Tanggal</th>
                <th class="px-5 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjaman as $item)
                <tr class="border-b last:border-0">
                    <td class="px-5 py-4">{{ $item->user->name }}</td>
                    <td class="px-5 py-4">{{ $item->alat->nama_alat }}</td>
                    <td class="px-5 py-4">{{ $item->qty }}</td>
                    <td class="px-5 py-4">{{ $item->tanggal_pinjam->format('d M Y') }}</td>
                    <td class="px-5 py-4 text-right">
                        <form class="inline" method="POST" action="{{ route('peminjaman.approve', $item) }}">@csrf<button class="text-green-700">Setujui</button></form>
                        <form class="inline ml-3" method="POST" action="{{ route('peminjaman.reject', $item) }}">@csrf<button class="text-red-700">Tolak</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500">Tidak ada data pending.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $peminjaman->links() }}</div>
@endsection
