@extends('layouts.stitch')

@section('content')
    <div class="mb-6">
        <h2 class="text-3xl font-extrabold font-manrope text-[#001535]">Detail Alat</h2>
    </div>

    <div class="stitch-card p-5 max-w-2xl space-y-2 text-sm">
        @if (!empty($alat->foto))
            <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}" class="w-48 h-32 object-cover rounded-lg border mb-3">
        @endif
        <p><strong>Kode:</strong> {{ $alat->kode_alat }}</p>
        <p><strong>Nama:</strong> {{ $alat->nama_alat }}</p>
        <p><strong>Kategori:</strong> {{ $alat->kategori ?? 'Umum' }}</p>
        <p><strong>Stok:</strong> {{ $alat->stok_tersedia }}/{{ $alat->stok_total }}</p>
        <p><strong>Kondisi:</strong> {{ $alat->kondisi }}</p>
        <p><strong>Status:</strong> {{ $alat->status_ketersediaan ? 'aktif' : 'nonaktif' }}</p>
        <a href="{{ route('alat.index') }}" class="text-blue-600">Kembali</a>
    </div>
@endsection
