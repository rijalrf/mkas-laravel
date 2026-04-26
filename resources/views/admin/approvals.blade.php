<x-app-layout>
    <x-slot name="title">Persetujuan</x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl border border-emerald-100 font-bold text-xs italic">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">
            <h3 class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-1">Menunggu Persetujuan</h3>
            
            @forelse($pendingTransactions as $tx)
            <div class="bg-white p-5 rounded-[28px] border border-slate-100 space-y-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center overflow-hidden">
                            @if($tx->user->photo)
                                <img src="{{ asset('storage/'.$tx->user->photo) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-xs font-bold">{{ substr($tx->user->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-black text-slate-800 uppercase tracking-tight leading-none mb-1">{{ $tx->user->name }}</p>
                            <p class="text-[8px] text-slate-400 font-bold tracking-widest leading-none">{{ $tx->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[13px] font-black {{ $tx->type == 'IN' ? 'text-emerald-600' : 'text-rose-600' }} italic">
                            {{ $tx->type == 'IN' ? '+' : '-' }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                    <p class="text-[10px] text-slate-600 font-bold leading-relaxed italic truncate"><span class="font-black text-slate-400 uppercase mr-1">Ket:</span> {{ $tx->description }}</p>
                </div>

                <div class="grid grid-cols-2 gap-3 pt-1">
                    <a href="{{ asset('storage/'.$tx->photo) }}" target="_blank" class="flex items-center justify-center py-2.5 bg-slate-100 rounded-xl text-[9px] font-black text-slate-600 gap-2 uppercase tracking-widest">
                        LIHAT STRUK
                    </a>
                    <form action="{{ route('admin.transactions.approve', $tx) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-2.5 bg-indigo-600 text-white rounded-xl text-[9px] font-black uppercase tracking-widest shadow-lg shadow-indigo-100">APPROVE</button>
                    </form>
                    <form action="{{ route('admin.transactions.reject', $tx) }}" method="POST" class="col-span-2 flex gap-2">
                        @csrf
                        <input type="text" name="admin_note" placeholder="Alasan penolakan..." required class="flex-1 px-4 py-2 bg-slate-50 border-none rounded-xl text-[10px] font-bold focus:ring-1 focus:ring-rose-500">
                        <button type="submit" class="px-4 py-2 bg-rose-500 text-white rounded-xl text-[9px] font-black uppercase tracking-widest">REJECT</button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-center py-10 text-[10px] font-bold text-slate-300 uppercase italic tracking-widest">Tidak ada antrian</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
