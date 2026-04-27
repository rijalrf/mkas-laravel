@php $hideNav = true; @endphp
<x-app-layout>
    <x-slot name="title">Pembayaran Iuran</x-slot>

    <div class="min-h-[70vh] flex flex-col items-center justify-center space-y-10 py-10 text-center">
        @if($existingDeposit && ($existingDeposit->status === 'PENDING' || $existingDeposit->status === 'APPROVED'))
            <!-- READ-ONLY STATE (Centered & Pure) -->
            <div class="w-full max-w-sm space-y-4 animate-fade-in px-6">
                <div class="flex flex-col items-center gap-4">
                    <div class="{{ $existingDeposit->status === 'APPROVED' ? 'text-emerald-500' : 'text-blue-500' }}">
                        @if($existingDeposit->status === 'APPROVED')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        @endif
                    </div>
                    <span class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.2em] border
                        @if($existingDeposit->status === 'APPROVED') bg-emerald-50 text-emerald-600 border-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800
                        @else bg-blue-50 text-blue-600 border-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800 @endif">
                        {{ $existingDeposit->status }}
                    </span>
                </div>

                <div class="space-y-3 px-6 pt-4">
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">
                        @if($existingDeposit->status === 'APPROVED') Pembayaran Berhasil @else Menunggu Verifikasi @endif
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400 leading-relaxed font-medium">
                        @if($existingDeposit->status === 'APPROVED')
                            Iuran Anda untuk bulan <span class="text-gray-900 dark:text-white font-bold">{{ \Carbon\Carbon::parse($existingDeposit->month)->translatedFormat('F Y') }}</span> telah berhasil disetujui. Terima kasih atas partisipasi Anda!
                        @else
                            Iuran Anda untuk bulan <span class="text-gray-900 dark:text-white font-bold">{{ \Carbon\Carbon::parse($existingDeposit->month)->translatedFormat('F Y') }}</span> telah dikirim dan sedang dalam proses verifikasi admin.
                        @endif
                    </p>
                </div>
            </div>
        @else
            <!-- MAIN PAYMENT VIEW (Form shown if NO deposit OR if existing is REJECTED) -->
            @if(!$account)
                <div class="w-full max-w-sm px-6">
                    <x-empty-state 
                        title="Rekening Belum Diatur" 
                        message="Admin belum mengatur rekening tujuan pembayaran iuran. Silakan hubungi admin."
                    />
                </div>
            @else
                @if($existingDeposit && $existingDeposit->status === 'REJECTED')
                    <div class="w-full max-w-xs px-6 mb-2">
                        <div class="bg-rose-50 dark:bg-rose-900/20 border border-rose-100 dark:border-rose-800 p-4 rounded-2xl flex items-start gap-3 text-left">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-rose-600 dark:text-rose-400 uppercase tracking-widest">Pembayaran Ditolak</p>
                                <p class="text-[10px] text-rose-500 dark:text-rose-400 leading-tight font-medium">Silakan ajukan kembali dengan data yang benar. Alasan: {{ $existingDeposit->admin_note ?? 'Data tidak sesuai' }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Amount Header -->
                <div class="space-y-1 animate-fade-in w-full px-6">
                    <p class="text-[11px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-[0.3em]">Total Tagihan</p>
                    <h2 class="text-5xl font-black text-gray-900 dark:text-white tracking-tighter italic">Rp {{ number_format($account->monthly_amount ?? 100000, 0, ',', '.') }}</h2>
                </div>

                <!-- Modern Card (Clean Glass) -->
                <div class="w-full max-w-xs aspect-[1.6/1] bg-slate-900 dark:bg-slate-800 rounded-[28px] p-6 text-white text-left relative overflow-hidden flex flex-col justify-between border border-slate-800 dark:border-slate-700 shadow-none">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-600/20 rounded-full -mr-10 -mt-10 blur-2xl"></div>
                    
                    <div class="relative z-10">
                        <p class="text-[9px] font-black text-blue-100/40 uppercase tracking-widest leading-none mb-1">Bank Pengelola</p>
                        <h3 class="text-lg font-black italic tracking-tight uppercase">{{ $account->bank_name ?? 'Mandiri' }}</h3>
                    </div>

                    <div class="relative z-10 space-y-4">
                        <div class="space-y-1">
                            <p class="text-[9px] font-black text-blue-100/40 uppercase tracking-widest leading-none">Nomor Rekening</p>
                            <div class="flex items-center gap-3">
                                <p class="text-2xl font-bold tracking-[0.1em]">{{ $account->account_number ?? '1234567890' }}</p>
                                <button onclick="copyToClipboard('{{ $account->account_number }}')" class="p-2 bg-white/10 hover:bg-white/20 rounded-xl transition-all active:scale-90">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" /></svg>
                                </button>
                            </div>
                        </div>
                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-[8px] font-black text-blue-100/40 uppercase tracking-widest leading-none">A/N</p>
                                <p class="text-[11px] font-bold uppercase tracking-tight">{{ $account->account_name ?? 'Bendahara' }}</p>
                            </div>
                            <p class="text-[11px] font-black tracking-widest">{{ $account->bank_code ?? '008' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Deposit Form -->
                <div class="w-full px-8 space-y-8 animate-fade-in-up">
                    <form action="{{ route('deposits.store') }}" method="POST" class="space-y-10">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $account->monthly_amount ?? 100000 }}">
                        
                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-[0.2em]">Pilih Bulan Pembayaran</label>
                            <div class="relative inline-block w-full max-w-[200px]">
                                <input type="month" name="month" required value="{{ date('Y-m') }}"
                                    class="w-full bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl py-4 px-2 text-center text-xl font-black text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all shadow-none appearance-none">
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full py-5 bg-blue-600 text-white rounded-2xl font-black text-xs hover:bg-blue-700 active:scale-95 transition-all uppercase tracking-[0.2em] shadow-none border-none">
                                Konfirmasi Pembayaran
                            </button>
                        </div>
                    </form>

                    <!-- Centered Guide -->
                    <div class="space-y-4 pt-4 border-t border-gray-100 dark:border-slate-700">
                        <p class="text-[10px] text-gray-400 dark:text-slate-500 font-bold uppercase tracking-widest leading-relaxed">
                            Lakukan transfer sesuai nominal ke rekening di atas, lalu tekan konfirmasi. Verifikasi manual oleh admin dalam 1x24 jam.
                        </p>
                    </div>
                </div>
            @endif
        @endif
    </div>

    @push('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                if (window.Alpine) {
                    window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Nomor rekening berhasil disalin!', type: 'success' } }));
                } else {
                    alert('Nomor rekening berhasil disalin!');
                }
            });
        }
    </script>
    @endpush
</x-app-layout>
