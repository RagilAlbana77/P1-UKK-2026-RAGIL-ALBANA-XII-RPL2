@extends('layouts.stitch')

@section('content')
<div class="mb-8 flex items-end justify-between gap-4">
    <div>
        <h2 class="text-3xl font-extrabold font-manrope text-[#001535]">Katalog Peralatan</h2>
        <p class="text-[#44474E]">Dashboard peminjam untuk ajukan pinjaman.</p>
    </div>
    <a href="{{ route('peminjaman.create') }}" class="stitch-btn-primary inline-flex items-center gap-2"><span class="material-symbols-outlined">add</span>Ajukan Peminjaman</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <x-stitch.kpi-card label="Total Tersedia" :value="$totalTersedia" icon="inventory_2" hint="Stok alat siap dipinjam" />
    <x-stitch.kpi-card label="Sedang Dipinjam" :value="$sedangDipinjam" icon="outbox" accent="#325F9E" hint="Total unit pinjaman aktif" />
    <x-stitch.kpi-card label="Perlu Kembali" :value="$perluKembali" icon="event_busy" accent="#BA1A1A" hint="Melewati tanggal rencana kembali" />
    <x-stitch.kpi-card label="Permintaan Aktif" :value="$permintaanAktif" icon="pending_actions" accent="#0098EE" hint="Menunggu persetujuan petugas" />
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 mb-8">
    @forelse ($alat as $item)
        <div class="stitch-card p-5">
            <h3 class="font-manrope font-bold text-lg text-[#001535]">{{ $item->nama_alat }}</h3>
            <p class="text-xs text-gray-500 mb-3">{{ $item->kode_alat }}</p>
            <p class="text-sm mb-4">Stok tersedia: <strong>{{ $item->stok_tersedia }}</strong></p>
            <a class="text-[#2DA8FF] font-semibold text-sm" href="{{ route('peminjaman.create') }}">Pinjam Alat</a>
        </div>
    @empty
        <p class="text-sm text-gray-500">Belum ada alat tersedia.</p>
    @endforelse
</div>

<div class="stitch-card p-6">
    <h3 class="font-manrope text-xl font-bold text-[#001535] mb-4">Riwayat Singkat</h3>
    <div class="space-y-2">
        @forelse ($riwayat as $item)
            <div class="p-3 rounded bg-[#F4F3F7] text-sm">{{ $item->alat->nama_alat }} - <span class="font-semibold">{{ $item->status }}</span></div>
        @empty
            <p class="text-sm text-gray-500">Belum ada riwayat.</p>
        @endforelse
    </div>
</div>
@endsection
