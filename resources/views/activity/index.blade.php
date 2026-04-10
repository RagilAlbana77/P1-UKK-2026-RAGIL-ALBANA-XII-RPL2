@extends('layouts.stitch')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-extrabold font-manrope text-[#001535]">Log Aktivitas</h2>
    <p class="text-[#44474E]">Riwayat perubahan transaksi sistem.</p>
</div>

<div class="stitch-card overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-[#F4F3F7] text-[11px] uppercase tracking-widest text-gray-600">
                <th class="px-5 py-4 text-left">Waktu</th>
                <th class="px-5 py-4 text-left">User</th>
                <th class="px-5 py-4 text-left">Aktivitas</th>
                <th class="px-5 py-4 text-left">IP</th>
                <th class="px-5 py-4 text-left">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($activities as $a)
                <tr class="border-b last:border-0">
                    <td class="px-5 py-4">{{ $a['waktu']->format('d M Y H:i') }}</td>
                    <td class="px-5 py-4">{{ $a['user'] }}</td>
                    <td class="px-5 py-4">{{ $a['aktivitas'] }}</td>
                    <td class="px-5 py-4">{{ $a['ip'] }}</td>
                    <td class="px-5 py-4">{{ $a['status'] }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500">Belum ada log aktivitas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
