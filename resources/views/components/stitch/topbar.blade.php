<header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-[#FAF9FD]/80 backdrop-blur-xl flex items-center justify-between px-8 z-40">
    <div class="relative w-96">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
        <input class="stitch-input pl-10 pr-4 py-2 text-sm" placeholder="Cari data..." type="text" />
    </div>
    <div class="text-sm text-[#0F2A52] font-semibold">{{ now()->format('d M Y') }}</div>
</header>
