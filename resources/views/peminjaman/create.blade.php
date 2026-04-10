@extends('layouts.stitch')

@section('content')
    <div class="mb-6">
        <h2 class="text-3xl font-extrabold font-manrope text-[#001535]">Ajukan Peminjaman</h2>
    </div>

    <form class="stitch-card p-6 space-y-4 max-w-3xl" method="POST" action="{{ route('peminjaman.store') }}">
        @csrf
        <select class="stitch-input p-3" name="alat_id" required>
            <option value="">-- pilih alat --</option>
            @foreach ($alat as $item)
                <option value="{{ $item->id }}" @selected(old('alat_id') == $item->id)>{{ $item->nama_alat }} (stok {{ $item->stok_tersedia }})</option>
            @endforeach
        </select>

        <input class="stitch-input p-3" name="qty" type="number" min="1" value="{{ old('qty', 1) }}" placeholder="Jumlah" required>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input class="stitch-input p-3" name="tanggal_pinjam" type="date" value="{{ old('tanggal_pinjam', now()->toDateString()) }}" required>
            <input class="stitch-input p-3" name="tanggal_rencana_kembali" type="date" value="{{ old('tanggal_rencana_kembali', now()->addDays(1)->toDateString()) }}" required>
        </div>

        <textarea class="stitch-input p-3" name="catatan" rows="4" placeholder="Catatan (opsional)">{{ old('catatan') }}</textarea>

        <div>
            <button class="stitch-btn-primary" type="submit">Simpan Pengajuan</button>
            <a href="{{ route('peminjaman.index') }}" class="stitch-btn-soft ml-2">Kembali</a>
        </div>
    </form>
@endsection
