@extends('layouts.stitch')

@section('content')
    <div class="mb-6">
        <h2 class="text-3xl font-extrabold font-manrope text-[#001535]">Detail Peminjaman</h2>
    </div>

    <div class="stitch-card p-6 max-w-3xl space-y-2 text-sm">
        <p><strong>Peminjam:</strong> {{ $peminjaman->user->name }}</p>
        <p><strong>Alat:</strong> {{ $peminjaman->alat->nama_alat }}</p>
        <p><strong>Qty:</strong> {{ $peminjaman->qty }}</p>
        <p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
        <p><strong>Rencana Kembali:</strong> {{ $peminjaman->tanggal_rencana_kembali->format('d M Y') }}</p>
        <p><strong>Tanggal Kembali:</strong> {{ $peminjaman->tanggal_kembali?->format('d M Y') ?? '-' }}</p>
        <p><strong>Status:</strong> {{ $peminjaman->status }}</p>
        <p><strong>Catatan:</strong> {{ $peminjaman->catatan ?? '-' }}</p>
        <a href="{{ route('peminjaman.index') }}" class="text-blue-600">Kembali</a>
    </div>
@endsection
