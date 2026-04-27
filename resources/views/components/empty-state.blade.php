@props([
    'title' => 'Tidak ada data',
    'message' => 'Belum ada data yang tersedia untuk saat ini.',
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center my-12 py-10 px-8 text-center']) }}>
    <!-- Clean Icon Container -->
    <div class="mb-6">
        <div class="w-20 h-20 bg-gray-50 rounded-[28px] flex items-center justify-center">
            @if(isset($icon))
                <div class="text-gray-400">
                    {{ $icon }}
                </div>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-5.25v9" />
                </svg>
            @endif
        </div>
    </div>

    <!-- Typography -->
    <div class="max-w-[260px] space-y-1">
        <h3 class="text-sm font-bold text-gray-800 tracking-widest uppercase">
            {{ $title }}
        </h3>
        <p class="text-[10px] text-gray-400 font-bold leading-relaxed uppercase tracking-widest opacity-70">
            {{ $message }}
        </p>
    </div>
</div>
