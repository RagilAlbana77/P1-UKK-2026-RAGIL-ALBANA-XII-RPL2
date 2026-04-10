@php
    $role = auth()->user()->role ?? 'peminjam';
@endphp

<aside class="bg-[#001535] h-screen w-64 fixed left-0 top-0 flex flex-col py-8 px-4 z-50 overflow-y-auto">
    <div class="mb-10 px-2">
        <h1 class="text-xl font-bold text-white tracking-tighter font-manrope">SiPinjam</h1>
        <p class="text-[10px] text-slate-400 uppercase tracking-widest">Loan Information System</p>
    </div>

    <nav class="flex-1 space-y-1 font-manrope text-sm">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white/5 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
            <span class="material-symbols-outlined {{ request()->routeIs('dashboard') ? 'text-[#2DA8FF]' : '' }}">dashboard</span>
            Dashboard
        </a>

        @if ($role === 'admin')
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('users.*') ? 'bg-white/5 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('users.*') ? 'text-[#2DA8FF]' : '' }}">group</span>
                User Management
            </a>
            <a href="{{ route('users.peminjam') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('users.peminjam') || request()->fullUrlIs('*role=peminjam*') ? 'bg-white/5 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('users.peminjam') || request()->fullUrlIs('*role=peminjam*') ? 'text-[#2DA8FF]' : '' }}">person</span>
                Peminjam
            </a>
        @endif

        <a href="{{ route('alat.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('alat.*') ? 'bg-white/5 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
            <span class="material-symbols-outlined {{ request()->routeIs('alat.*') ? 'text-[#2DA8FF]' : '' }}">inventory_2</span>
            Inventaris
        </a>

        <a href="{{ route('peminjaman.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('peminjaman.index') ? 'bg-white/5 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
            <span class="material-symbols-outlined {{ request()->routeIs('peminjaman.index') ? 'text-[#2DA8FF]' : '' }}">handshake</span>
            Peminjaman
        </a>

        @if (in_array($role, ['admin','petugas'], true))
            <a href="{{ route('peminjaman.approval') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('peminjaman.approval') ? 'bg-white/5 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('peminjaman.approval') ? 'text-[#2DA8FF]' : '' }}">verified</span>
                Persetujuan
            </a>
            <a href="{{ route('peminjaman.pengembalian') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('peminjaman.pengembalian') ? 'bg-white/5 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('peminjaman.pengembalian') ? 'text-[#2DA8FF]' : '' }}">assignment_return</span>
                Pengembalian
            </a>
            <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('reports.*') ? 'bg-white/5 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('reports.*') ? 'text-[#2DA8FF]' : '' }}">analytics</span>
                Laporan
            </a>
            <a href="{{ route('activity.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('activity.*') ? 'bg-white/5 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('activity.*') ? 'text-[#2DA8FF]' : '' }}">history</span>
                Log Aktivitas
            </a>
        @else
            <a href="{{ route('peminjaman.riwayat') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('peminjaman.riwayat') ? 'bg-white/5 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('peminjaman.riwayat') ? 'text-[#2DA8FF]' : '' }}">history</span>
                Riwayat
            </a>
        @endif
    </nav>

    <div class="mt-auto pt-8 border-t border-white/10 text-sm">
        <div class="px-4 mb-3">
            <p class="text-white font-semibold">{{ auth()->user()->name ?? '-' }}</p>
            <p class="text-slate-400 text-xs uppercase tracking-wider">{{ $role }}</p>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="px-4">
            @csrf
            <button type="submit" class="w-full text-left flex items-center gap-3 py-2 text-slate-400 hover:text-white transition-colors">
                <span class="material-symbols-outlined">logout</span>
                Logout
            </button>
        </form>
    </div>
</aside>
