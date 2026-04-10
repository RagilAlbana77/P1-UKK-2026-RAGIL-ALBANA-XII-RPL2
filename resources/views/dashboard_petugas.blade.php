@extends('layouts.stitch')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-extrabold font-manrope text-[#001535]">Dashboard Petugas</h2>
    <p class="text-[#44474E]">Verifikasi persetujuan dan pengembalian alat.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <x-stitch.kpi-card label="Pending Approval" :value="$totalPending" icon="pending_actions" accent="#BA1A1A" />
    <x-stitch.kpi-card label="Perlu Pengembalian" :value="$totalPengembalian" icon="assignment_return" accent="#325F9E" />
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
    <div class="stitch-card p-6">
        <h3 class="font-manrope text-xl font-bold text-[#001535] mb-4">Persetujuan Menunggu</h3>
        <div class="space-y-3">
            @forelse ($pending as $item)
                <div class="p-3 rounded-lg bg-[#F4F3F7]">
                    <p class="font-semibold">{{ $item->user->name }} - {{ $item->alat->nama_alat }}</p>
                    <p class="text-xs text-gray-500 mb-2">Qty {{ $item->qty }} | {{ $item->tanggal_pinjam->format('d M Y') }}</p>
                    <form method="POST" action="{{ route('peminjaman.approve', $item) }}" class="inline">@csrf<button class="text-green-700 text-sm">Setujui</button></form>
                    <form method="POST" action="{{ route('peminjaman.reject', $item) }}" class="inline ml-3">@csrf<button class="text-red-700 text-sm">Tolak</button></form>
                </div>
            @empty
                <p class="text-sm text-gray-500">Tidak ada data pending.</p>
            @endforelse
        </div>
    </div>

    <div class="stitch-card p-6">
        <h3 class="font-manrope text-xl font-bold text-[#001535] mb-4">Pengembalian</h3>
        <div class="space-y-3">
            @forelse ($perluPengembalian as $item)
                <div class="p-3 rounded-lg bg-[#F4F3F7]">
                    <p class="font-semibold">{{ $item->user->name }} - {{ $item->alat->nama_alat }}</p>
                    <p class="text-xs text-gray-500 mb-2">Qty {{ $item->qty }} | Batas {{ $item->tanggal_rencana_kembali->format('d M Y') }}</p>
                    <form method="POST" action="{{ route('peminjaman.kembalikan', $item) }}">@csrf<button class="text-purple-700 text-sm">Verifikasi Alat</button></form>
                </div>
            @empty
                <p class="text-sm text-gray-500">Tidak ada data pengembalian.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
