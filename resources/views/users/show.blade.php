@extends('layouts.stitch')

@section('content')
<h2 class="text-3xl font-extrabold font-manrope text-[#001535] mb-6">Detail User</h2>
<div class="stitch-card p-6 max-w-3xl space-y-2 text-sm">
    <p><strong>Nama:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Role:</strong> {{ $user->role }}</p>
    <p><strong>Bergabung:</strong> {{ $user->created_at->format('d M Y') }}</p>
    <a class="text-blue-600" href="{{ route('users.index') }}">Kembali</a>
</div>
@endsection
