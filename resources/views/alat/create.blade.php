@extends('layouts.stitch')

@section('content')
    <div class="mb-6">
        <h2 class="text-3xl font-extrabold font-manrope text-[#001535]">Tambah Alat</h2>
    </div>

    <form class="stitch-card p-6 space-y-4 max-w-3xl" method="POST" action="{{ route('alat.store') }}" enctype="multipart/form-data">
        @csrf
        <input class="stitch-input p-3" name="kode_alat" placeholder="Kode Alat" value="{{ old('kode_alat') }}" required>
        <input class="stitch-input p-3" name="nama_alat" placeholder="Nama Alat" value="{{ old('nama_alat') }}" required>

        <select class="stitch-input p-3" name="kategori" required>
            @foreach (['Elektronik', 'Multimedia', 'Audio', 'Umum'] as $kategori)
                <option value="{{ $kategori }}" @selected(old('kategori') === $kategori)>{{ $kategori }}</option>
            @endforeach
        </select>

        <div>
            <label class="block text-sm font-semibold mb-2">Foto Alat</label>
            <input class="stitch-input p-3" type="file" name="foto" accept=".jpg,.jpeg,.png,.webp">
            <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG/WEBP, maksimal 2MB.</p>
        </div>

        <input class="stitch-input p-3" name="stok_total" type="number" min="0" placeholder="Stok" value="{{ old('stok_total', 1) }}" required>

        <select class="stitch-input p-3" name="kondisi" required>
            <option value="baik">baik</option>
            <option value="rusak_ringan">rusak_ringan</option>
            <option value="rusak">rusak</option>
        </select>

        <label class="inline-flex items-center gap-2 text-sm">
            <input type="checkbox" name="status_ketersediaan" value="1" checked>
            Status ketersediaan aktif
        </label>

        <div class="pt-2">
            <button class="stitch-btn-primary" type="submit">Simpan</button>
            <a href="{{ route('alat.index') }}" class="stitch-btn-soft ml-2">Kembali</a>
        </div>
    </form>
@endsection
