@props(['label', 'value', 'accent' => '#2DA8FF', 'hint' => null, 'icon' => 'insights'])

<div class="stitch-card p-6 relative overflow-hidden">
    <div class="absolute left-0 top-0 bottom-0 w-1" style="background-color: {{ $accent }}"></div>
    <div class="flex justify-between items-start mb-3">
        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">{{ $label }}</p>
        <span class="material-symbols-outlined text-gray-400">{{ $icon }}</span>
    </div>
    <h3 class="text-3xl font-extrabold font-manrope text-[#001535]">{{ $value }}</h3>
    @if ($hint)
        <p class="text-xs text-gray-500 mt-2">{{ $hint }}</p>
    @endif
</div>
