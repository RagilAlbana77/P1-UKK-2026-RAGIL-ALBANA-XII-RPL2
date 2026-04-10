@extends('layouts.stitch')

@section('content')
<div class="flex items-end justify-between mb-8">
    <div>
        <h2 class="text-3xl font-extrabold font-manrope text-[#001535]">Manajemen Pengguna</h2>
        <p class="text-[#44474E]">
            Kelola akun admin, petugas, dan peminjam.
            @if (!empty($activeRole))
                <span class="font-semibold">Filter aktif: {{ strtoupper($activeRole) }}</span>
            @endif
        </p>
    </div>
    <a href="{{ route('users.create') }}" class="stitch-btn-primary">Tambah User</a>
</div>

<div class="mb-4 flex items-center gap-2 text-sm">
    <a href="{{ route('users.index') }}" class="px-3 py-1.5 rounded-lg {{ empty($activeRole) ? 'bg-[#001535] text-white' : 'bg-[#F4F3F7] text-[#001535]' }}">Semua</a>
    <a href="{{ route('users.index', ['role' => 'admin']) }}" class="px-3 py-1.5 rounded-lg {{ $activeRole === 'admin' ? 'bg-[#001535] text-white' : 'bg-[#F4F3F7] text-[#001535]' }}">Admin</a>
    <a href="{{ route('users.index', ['role' => 'petugas']) }}" class="px-3 py-1.5 rounded-lg {{ $activeRole === 'petugas' ? 'bg-[#001535] text-white' : 'bg-[#F4F3F7] text-[#001535]' }}">Petugas</a>
    <a href="{{ route('users.index', ['role' => 'peminjam']) }}" class="px-3 py-1.5 rounded-lg {{ $activeRole === 'peminjam' ? 'bg-[#001535] text-white' : 'bg-[#F4F3F7] text-[#001535]' }}">Peminjam</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <x-stitch.kpi-card label="Admin" :value="$totalAdmin" icon="shield" />
    <x-stitch.kpi-card label="Petugas" :value="$totalPetugas" icon="support_agent" accent="#325F9E" />
    <x-stitch.kpi-card label="Peminjam" :value="$totalPeminjam" icon="person" accent="#0098EE" />
</div>

<div class="stitch-card overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-[#F4F3F7] text-[11px] uppercase tracking-widest text-gray-600">
                <th class="px-5 py-4 text-left">Nama</th>
                <th class="px-5 py-4 text-left">Email</th>
                <th class="px-5 py-4 text-left">Role</th>
                <th class="px-5 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr class="border-b last:border-0">
                    <td class="px-5 py-4">{{ $user->name }}</td>
                    <td class="px-5 py-4">{{ $user->email }}</td>
                    <td class="px-5 py-4">{{ $user->role }}</td>
                    <td class="px-5 py-4 text-right space-x-2">
                        <a href="{{ route('users.show', $user) }}" class="text-blue-600">Detail</a>
                        <a href="{{ route('users.edit', $user) }}" class="text-amber-600">Edit</a>
                        <form class="inline" method="POST" action="{{ route('users.destroy', $user) }}">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-5 py-8 text-center text-gray-500">Belum ada data user.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $users->links() }}</div>
@endsection
