@extends('layouts.stitch')

@section('content')
<h2 class="text-3xl font-extrabold font-manrope text-[#001535] mb-6">Tambah User</h2>
<form class="stitch-card p-6 max-w-3xl space-y-4" method="POST" action="{{ route('users.store') }}">
    @csrf
    <input name="name" class="stitch-input p-3" placeholder="Nama" value="{{ old('name') }}" required>
    <input name="email" type="email" class="stitch-input p-3" placeholder="Email" value="{{ old('email') }}" required>
    <select name="role" class="stitch-input p-3" required>
        @foreach(['admin','petugas','peminjam'] as $role)
            <option value="{{ $role }}" @selected(old('role') === $role)>{{ $role }}</option>
        @endforeach
    </select>
    <input name="password" type="password" class="stitch-input p-3" placeholder="Password" required>
    <input name="password_confirmation" type="password" class="stitch-input p-3" placeholder="Konfirmasi Password" required>
    <button class="stitch-btn-primary" type="submit">Simpan</button>
    <a class="stitch-btn-soft ml-2" href="{{ route('users.index') }}">Kembali</a>
</form>
@endsection
