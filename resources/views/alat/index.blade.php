@extends('layouts.stitch')

@section('content')
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold font-manrope text-[#001535]">Inventaris Alat</h2>
            <p class="text-[#44474E]">Kelola alat dan stok sesuai desain dashboard Stitch.</p>
        </div>
        @if (auth()->user()?->role === 'admin')
            <a href="{{ route('alat.create') }}" class="stitch-btn-primary inline-flex items-center gap-2">
                <span class="material-symbols-outlined">add</span>
                Tambah Alat
            </a>
        @endif
    </div>

    <div class="stitch-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-[#F4F3F7] text-[11px] uppercase tracking-widest text-gray-600">
                        <th class="px-5 py-4 text-left">Kode Alat</th>
                        <th class="px-5 py-4 text-left">Nama Alat</th>
                        <th class="px-5 py-4 text-left">Kategori</th>
                        <th class="px-5 py-4 text-left">Stok</th>
                        <th class="px-5 py-4 text-left">Kondisi</th>
                        <th class="px-5 py-4 text-left">Status</th>
                        <th class="px-5 py-4 text-right">Edit</th>
                        <th class="px-5 py-4 text-right">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($alat as $item)
                        <tr class="border-b last:border-0 hover:bg-[#FAF9FD]">
                            <td class="px-5 py-4"><span class="font-mono text-xs font-semibold bg-blue-100 text-blue-900 px-2 py-1 rounded">{{ $item->kode_alat }}</span></td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="rounded-lg bg-[#F4F3F7] overflow-hidden border border-[#E3E2E6] shrink-0 flex items-center justify-center"
                                        style="width: 40px; height: 40px; min-width: 40px; min-height: 40px;"
                                    >
                                        @if (!empty($item->foto))
                                            <img
                                                src="{{ asset('storage/' . $item->foto) }}"
                                                alt="{{ $item->nama_alat }}"
                                                loading="lazy"
                                                style="width: 40px; height: 40px; min-width: 40px; min-height: 40px; max-width: 40px; max-height: 40px; object-fit: cover; display: block;"
                                            >
                                        @else
                                            <span class="material-symbols-outlined text-[#325F9E] text-[18px]">inventory_2</span>
                                        @endif
                                    </div>
                                    <span class="font-semibold leading-tight">{{ $item->nama_alat }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4">{{ $item->kategori ?? 'Umum' }}</td>
                            <td class="px-5 py-4">{{ $item->stok_tersedia }}/{{ $item->stok_total }}</td>
                            <td class="px-5 py-4">{{ $item->kondisi }}</td>
                            <td class="px-5 py-4">
                                <span class="stitch-badge {{ $item->status_ketersediaan ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                                    {{ $item->status_ketersediaan ? 'TERSEDIA' : 'NONAKTIF' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                @if (auth()->user()?->role === 'admin')
                                    <a href="{{ route('alat.edit', $item) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-md hover:bg-[#F4F3F7] text-amber-600" title="Edit">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right">
                                @if (auth()->user()?->role === 'admin')
                                    <form class="inline" method="POST" action="{{ route('alat.destroy', $item) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-md hover:bg-[#FDECEC] text-red-600" title="Delete">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-5 py-8 text-center text-gray-500">Belum ada data alat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $alat->links() }}</div>
@endsection
