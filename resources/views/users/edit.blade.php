@extends('layouts.stitch')

@section('content')
<h2 class="text-3xl font-extrabold font-manrope text-[#001535] mb-6">Edit User</h2>
<form class="stitch-card p-6 max-w-3xl space-y-4" method="POST" action="{{ route('users.update', $user) }}">
    @csrf
    @method('PUT')
    <input name="name" class="stitch-input p-3" value="{{ old('name', $user->name) }}" required>
    <input name="email" type="email" class="stitch-input p-3" value="{{ old('email', $user->email) }}" required>
    <select name="role" class="stitch-input p-3" required>
        @foreach(['admin','petugas','peminjam'] as $role)
            <option value="{{ $role }}" @selected(old('role', $user->role) === $role)>{{ $role }}</option>
        @endforeach
    </select>
    <input name="password" type="password" class="stitch-input p-3" placeholder="Password baru (opsional)">
    <input name="password_confirmation" type="password" class="stitch-input p-3" placeholder="Konfirmasi Password baru">
    <button class="stitch-btn-primary" type="submit">Update</button>
    <a class="stitch-btn-soft ml-2" href="{{ route('users.index') }}">Kembali</a>
</form>
@endsection
