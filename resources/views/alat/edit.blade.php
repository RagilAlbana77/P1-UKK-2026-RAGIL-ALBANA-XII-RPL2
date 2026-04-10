@extends('layouts.stitch')

@section('content')
    <div class="mb-6">
        <h2 class="text-3xl font-extrabold font-manrope text-[#001535]">Edit Alat</h2>
    </div>

    <form class="stitch-card p-6 space-y-4 max-w-3xl" method="POST" action="{{ route('alat.update', $alat) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input class="stitch-input p-3" name="kode_alat" value="{{ old('kode_alat', $alat->kode_alat) }}" required>
        <input class="stitch-input p-3" name="nama_alat" value="{{ old('nama_alat', $alat->nama_alat) }}" required>

        <select class="stitch-input p-3" name="kategori" required>
            @foreach (['Elektronik', 'Multimedia', 'Audio', 'Umum'] as $kategori)
                <option value="{{ $kategori }}" @selected(old('kategori', $alat->kategori ?? 'Umum') === $kategori)>{{ $kategori }}</option>
            @endforeach
        </select>

        <div>
            <label class="block text-sm font-semibold mb-2">Foto Alat</label>
            @if (!empty($alat->foto))
                <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}" class="w-36 h-24 object-cover rounded-lg border mb-2">
            @endif
            <input class="stitch-input p-3" type="file" name="foto" accept=".jpg,.jpeg,.png,.webp">
            <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti foto.</p>
        </div>

        <input class="stitch-input p-3" name="stok_total" type="number" min="0" value="{{ old('stok_total', $alat->stok_total) }}" required>
        <p class="text-xs text-gray-500">Stok tersedia akan disesuaikan otomatis berdasarkan jumlah yang sedang dipinjam.</p>

        <select class="stitch-input p-3" name="kondisi" required>
            @foreach (['baik', 'rusak_ringan', 'rusak'] as $kondisi)
                <option value="{{ $kondisi }}" @selected(old('kondisi', $alat->kondisi) === $kondisi)>{{ $kondisi }}</option>
            @endforeach
        </select>

        <label class="inline-flex items-center gap-2 text-sm">
            <input type="checkbox" name="status_ketersediaan" value="1" @checked(old('status_ketersediaan', $alat->status_ketersediaan))>
            Status ketersediaan aktif
        </label>

        <div class="pt-2">
            <button class="stitch-btn-primary" type="submit">Update</button>
            <a href="{{ route('alat.index') }}" class="stitch-btn-soft ml-2">Kembali</a>
        </div>
    </form>
@endsection
