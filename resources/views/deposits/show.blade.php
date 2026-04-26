<x-app-layout>
    <x-slot name="title">Detail Iuran</x-slot>

    @php
        $statusColors = [
            'APPROVED' => ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-100', 'text' => 'text-emerald-600', 'icon' => 'bg-emerald-100'],
            'REJECTED' => ['bg' => 'bg-rose-50', 'border' => 'border-rose-100', 'text' => 'text-rose-600', 'icon' => 'bg-rose-100'],
            'PENDING' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-100', 'text' => 'text-blue-600', 'icon' => 'bg-blue-100'],
        ];
        $color = $statusColors[$deposit->status] ?? $statusColors['PENDING'];
    @endphp

    <!-- STATUS HEADER CARD -->
    <div class="p-8 rounded-xl shadow-sm flex flex-col items-center text-center space-y-4 border {{ $color['bg'] }} {{ $color['border'] }}">
        
        <!-- Status Icon -->
        <div class="w-20 h-20 rounded-full flex items-center justify-center border-4 border-white shadow-sm {{ $color['icon'] }} {{ $color['text'] }}">
            @if($deposit->status == 'APPROVED')
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
            @elseif($deposit->status == 'REJECTED')
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            @endif
        </div>
        
        <div>
            <h2 class="text-xl font-bold tracking-tight text-gray-900">Iuran Bulan {{ \Carbon\Carbon::parse($deposit->month)->translatedFormat('F Y') }}</h2>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-[0.2em] mt-1">Deposit Iuran Warga</p>
        </div>

        <div class="inline-flex px-4 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border bg-white {{ $color['border'] }} {{ $color['text'] }}">
            {{ $deposit->status }}
        </div>
    </div>

    <!-- DEPOSIT DETAILS -->
    <div class="space-y-3">
        <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider px-1">Informasi Detail</h4>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-50">
            <!-- Nominal -->
            <div class="p-4 flex items-center justify-between text-left">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Nominal</p>
                <p class="text-sm font-bold text-blue-600">
                    Rp {{ number_format($deposit->amount, 0, ',', '.') }}
                </p>
            </div>
            
            <!-- User -->
            <div class="p-4 flex items-center justify-between text-left">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Penyetor</p>
                <div class="flex items-center gap-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($deposit->user->name) }}&background=f1f5f9&color=64748b" class="w-5 h-5 rounded-full">
                    <p class="text-sm font-bold text-gray-800">{{ $deposit->user->name }}</p>
                </div>
            </div>

            <!-- Date Time -->
            <div class="p-4 flex items-center justify-between text-left">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu Setor</p>
                <p class="text-sm font-bold text-gray-800">{{ $deposit->created_at->format('d M Y, H:i') }} WIB</p>
            </div>

            <!-- Approval Info -->
            @if($deposit->status !== 'PENDING')
                <div class="p-4 flex items-center justify-between text-left">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Diproses Oleh</p>
                    <p class="text-sm font-bold text-gray-800">Administrator</p>
                </div>
                <div class="p-4 flex items-center justify-between text-left">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu Respon</p>
                    <p class="text-sm font-bold text-gray-800">{{ $deposit->updated_at->format('d M Y, H:i') }} WIB</p>
                </div>
                
                @if($deposit->admin_note)
                    <div class="p-4 bg-gray-50/50 border-y border-gray-50 text-left">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Catatan Admin</p>
                        <p class="text-sm font-medium text-gray-600 italic leading-relaxed">"{{ $deposit->admin_note }}"</p>
                    </div>
                @endif

                @if($deposit->admin_photo)
                    <div class="p-4 space-y-2 text-left">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Bukti Respon Admin</p>
                        <div class="bg-gray-100 p-1.5 rounded-lg border border-gray-200">
                            <img src="{{ asset('storage/'.$deposit->admin_photo) }}" class="w-full rounded-md object-cover max-h-44 shadow-sm" alt="Bukti Admin">
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- ADMIN ACTIONS (AT THE VERY BOTTOM) -->
    @if(Auth::user()->role === 'admin' && $deposit->status === 'PENDING')
        <div class="space-y-3 pt-6">
            <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider px-1">Tindakan Admin</h4>
            <div class="grid grid-cols-2 gap-3">
                <button @click="categoryId = '{{ $deposit->id }}'; openSheet('approve-dp')" class="w-full py-4 bg-emerald-600 text-white rounded-xl font-bold text-sm shadow-md shadow-emerald-100 active:scale-[0.98] transition-all">
                    Setujui
                </button>
                <button @click="categoryId = '{{ $deposit->id }}'; openSheet('reject-dp')" class="w-full py-4 bg-rose-600 text-white rounded-xl font-bold text-sm shadow-md shadow-rose-100 active:scale-[0.98] transition-all">
                    Tolak
                </button>
            </div>
        </div>
    @endif
</x-app-layout>
