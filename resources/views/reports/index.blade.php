@extends('layouts.stitch')

@section('content')
<div class="flex items-end justify-between mb-8">
    <div>
        <h2 class="text-3xl font-extrabold font-manrope text-[#001535]">Laporan Transaksi & Inventaris</h2>
        <p class="text-[#44474E]">Filter data peminjaman sesuai kebutuhan.</p>
    </div>
</div>

<form class="stitch-card p-4 mb-6 grid grid-cols-1 md:grid-cols-4 gap-3" method="GET" action="{{ route('reports.index') }}">
    <input class="stitch-input p-3" type="date" name="date_from" value="{{ request('date_from') }}">
    <input class="stitch-input p-3" type="date" name="date_to" value="{{ request('date_to') }}">
    <select class="stitch-input p-3" name="status">
        <option value="">Semua Status</option>
        @foreach(['pending','dipinjam','rejected','dikembalikan'] as $status)
            <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
        @endforeach
    </select>
    <button class="stitch-btn-primary" type="submit">Filter</button>
</form>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <x-stitch.kpi-card label="Total Alat" :value="$totalAlat" icon="inventory" />
    <x-stitch.kpi-card label="Sedang Dipinjam" :value="$totalDipinjam" icon="outbox" accent="#325F9E" />
    <x-stitch.kpi-card label="Selesai" :value="$totalDikembalikan" icon="task_alt" accent="#0098EE" />
</div>

<div class="stitch-card overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-[#F4F3F7] text-[11px] uppercase tracking-widest text-gray-600">
                <th class="px-5 py-4 text-left">ID</th>
                <th class="px-5 py-4 text-left">Peminjam</th>
                <th class="px-5 py-4 text-left">Alat</th>
                <th class="px-5 py-4 text-left">Tanggal</th>
                <th class="px-5 py-4 text-left">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reports as $row)
                <tr class="border-b last:border-0">
                    <td class="px-5 py-4">#{{ $row->id }}</td>
                    <td class="px-5 py-4">{{ $row->user->name }}</td>
                    <td class="px-5 py-4">{{ $row->alat->nama_alat }}</td>
                    <td class="px-5 py-4">{{ $row->tanggal_pinjam->format('d M Y') }}</td>
                    <td class="px-5 py-4">{{ $row->status }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500">Belum ada data laporan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $reports->links() }}</div>
@endsection
