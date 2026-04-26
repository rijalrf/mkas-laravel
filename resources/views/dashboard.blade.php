<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <!-- UNIFIED SUMMARY CARD (SOFT SaaS STYLE) -->
    <div class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100 shadow-sm space-y-6">
        <!-- Total Balance -->
        <div>
            <p class="text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] mb-1">Total Saldo Kas</p>
            <h3 class="text-3xl font-black tracking-tight text-blue-900 italic">Rp {{ number_format($saldoUtama, 0, ',', '.') }}</h3>
        </div>
        
        <!-- Grid for In/Out -->
        <div class="grid grid-cols-2 gap-4 pt-5 border-t border-blue-100">
            <div class="space-y-1">
                <div class="flex items-center gap-1.5 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" /></svg>
                    <p class="text-[9px] font-bold uppercase tracking-widest leading-none">Pemasukan</p>
                </div>
                <p class="text-sm font-bold text-gray-700 tracking-tight">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</p>
            </div>
            <div class="space-y-1 border-l border-blue-100 pl-4">
                <div class="flex items-center gap-1.5 text-rose-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" /></svg>
                    <p class="text-[9px] font-bold uppercase tracking-widest leading-none">Pengeluaran</p>
                </div>
                <p class="text-sm font-bold text-gray-700 tracking-tight">Rp {{ number_format($totalOut, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- ADMIN TODO SECTION -->
    @if(Auth::user()->role === 'admin' && (count($pendingTransactions) > 0 || count($pendingDeposits) > 0))
    <div class="space-y-3">
        <div class="flex items-center justify-between px-1">
            <h4 class="text-[11px] font-black text-rose-500 uppercase tracking-[0.2em] flex items-center gap-2">
                <span class="w-1.5 h-1.5 bg-rose-500 rounded-full animate-ping"></span>
                Butuh Persetujuan ({{ count($pendingTransactions) + count($pendingDeposits) }})
            </h4>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-rose-100 overflow-hidden divide-y divide-gray-50">
            <!-- Pending Deposits -->
            @foreach($pendingDeposits as $dp)
                <a href="{{ route('deposits.show', $dp->id) }}" class="p-4 flex items-center justify-between bg-rose-50/30 active:bg-rose-50 transition-all">
                    <div class="flex flex-col gap-1 min-w-0">
                        <p class="text-sm font-bold text-gray-800 truncate">Iuran: {{ $dp->user->name }}</p>
                        <p class="text-[9px] text-gray-400 font-bold uppercase">Bulan {{ \Carbon\Carbon::parse($dp->month)->translatedFormat('F Y') }}</p>
                    </div>
                    <div class="text-right shrink-0 ml-4">
                        <p class="text-xs font-black text-blue-600">Rp {{ number_format($dp->amount, 0, ',', '.') }}</p>
                        <span class="text-[8px] font-black text-rose-500 uppercase tracking-widest">Persetujuan</span>
                    </div>
                </a>
            @endforeach

            <!-- Pending Transactions -->
            @foreach($pendingTransactions as $tx)
                <a href="{{ route('history.show', $tx->id) }}" class="p-4 flex items-center justify-between bg-rose-50/30 active:bg-rose-50 transition-all">
                    <div class="flex flex-col gap-1 min-w-0">
                        <p class="text-sm font-bold text-gray-800 truncate">{{ $tx->description }}</p>
                        <p class="text-[9px] text-gray-400 font-bold uppercase">{{ $tx->user->name }} • {{ $tx->category->name }}</p>
                    </div>
                    <div class="text-right shrink-0 ml-4">
                        <p class="text-xs font-black @if($tx->type == 'IN') text-blue-600 @else text-rose-600 @endif">
                            {{ $tx->type == 'IN' ? '+' : '-' }}Rp {{ number_format($tx->amount, 0, ',', '.') }}
                        </p>
                        <span class="text-[8px] font-black text-rose-500 uppercase tracking-widest">Persetujuan</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- CATEGORY LIST (HORIZONTAL SCROLL) -->
    <div class="space-y-3">
        <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider px-1">Kategori Utama</h4>
        <div class="flex items-center gap-3 overflow-x-auto hide-scroll pb-2 px-1">
            @foreach($categories->take(5) as $cat)
                <button @click="selectedType = 'IN'; categoryId = '{{ $cat->id }}'; categoryName = '{{ $cat->name }}'; openSheet('form')" 
                    class="flex flex-col items-center gap-2 shrink-0 group active:scale-95 transition-all">
                    <div class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center group-hover:border-blue-200 group-hover:bg-blue-50 transition-colors text-blue-600">
                        <span class="text-xs font-black uppercase">{{ substr($cat->name, 0, 2) }}</span>
                    </div>
                    <span class="text-[10px] font-bold text-gray-500 truncate w-14 text-center uppercase tracking-tighter">{{ $cat->name }}</span>
                </button>
            @endforeach
            
            <button @click="openSheet('categories')" class="flex flex-col items-center gap-2 shrink-0 active:scale-95 transition-all">
                <div class="w-14 h-14 bg-gray-50 rounded-2xl border border-dashed border-gray-300 flex items-center justify-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" /></svg>
                </div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Lainnya</span>
            </button>
        </div>
    </div>

    <!-- MONTHLY COMPARISON INFO -->
    <div class="flex items-center gap-3 px-1 py-1">
        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 {{ $percentChange <= 0 ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
            @if($percentChange <= 0)
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6L9 12.75l4.286-4.286L21 15.25m-18 0l18 0" /></svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.286 4.286L21 8.75m-18 0l18 0" /></svg>
            @endif
        </div>
        <div class="min-w-0">
            <p class="text-xs font-semibold text-gray-700 leading-tight">
                Pengeluaran bulan ini lebih <span class="{{ $percentChange <= 0 ? 'text-emerald-600' : 'text-rose-600' }} font-bold">{{ $percentChange <= 0 ? 'kecil' : 'besar' }} {{ abs(round($percentChange)) }}%</span> dari bulan kemarin.
            </p>
        </div>
    </div>

    <!-- LINE CHART: TREND -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 space-y-4">
        <div class="flex items-center justify-between">
            <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Tren Kas Bulanan</h4>
            <form action="{{ route('dashboard') }}" method="GET" id="period-form">
                <select name="period" onchange="document.getElementById('period-form').submit()" class="text-[10px] font-bold border-none bg-gray-50 rounded-lg py-1 pl-2 pr-8 focus:ring-0 text-gray-500">
                    <option value="3" {{ $period == 3 ? 'selected' : '' }}>3 Bulan</option>
                    <option value="6" {{ $period == 6 ? 'selected' : '' }}>6 Bulan</option>
                    <option value="12" {{ $period == 12 ? 'selected' : '' }}>12 Bulan</option>
                </select>
                <input type="hidden" name="year" value="{{ $selectedYear }}">
            </form>
        </div>
        <div class="h-48 relative">
            <canvas id="lineChart"></canvas>
        </div>
        <div class="flex items-center gap-4 px-1">
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                <span class="text-[9px] font-bold text-gray-400 uppercase">Pemasukan</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                <span class="text-[9px] font-bold text-gray-400 uppercase">Pengeluaran</span>
            </div>
        </div>
    </div>

    <!-- PIE CHART: CATEGORY DISTRIBUTION -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 space-y-4">
        <div class="flex items-center justify-between">
            <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Pengeluaran Kategori</h4>
            <form action="{{ route('dashboard') }}" method="GET" id="year-form">
                <select name="year" onchange="document.getElementById('year-form').submit()" class="text-[10px] font-bold border-none bg-gray-50 rounded-lg py-1 pl-2 pr-8 focus:ring-0 text-gray-500">
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="period" value="{{ $period }}">
            </form>
        </div>
        @if($pieData->count() > 0)
            <div class="flex items-center gap-4">
                <div class="w-32 h-32 shrink-0">
                    <canvas id="pieChart"></canvas>
                </div>
                <div class="flex-1 space-y-2">
                    @foreach($pieData->take(4) as $index => $item)
                        <div class="flex items-center justify-between min-w-0">
                            <div class="flex items-center gap-2 min-w-0">
                                <span class="w-1.5 h-1.5 rounded-full shrink-0" style="background-color: {{ ['#3b82f6', '#f43f5e', '#f59e0b', '#10b981', '#6366f1'][$index % 5] }}"></span>
                                <span class="text-[10px] font-medium text-gray-500 truncate uppercase tracking-tighter">{{ $item->category->name }}</span>
                            </div>
                            <span class="text-[10px] font-bold text-gray-700 ml-1">{{ round(($item->total / max($totalOut, 1)) * 100) }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="h-32 flex flex-col items-center justify-center opacity-20">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg>
                <p class="text-[10px] font-bold uppercase tracking-widest mt-2">Tidak ada data</p>
            </div>
        @endif
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Line Chart
            new Chart(document.getElementById('lineChart'), {
                type: 'line',
                data: { 
                    labels: {!! json_encode($chartMonths) !!}, 
                    datasets: [
                        { 
                            label: 'Pemasukan',
                            data: {!! json_encode($chartTotalIn) !!}, 
                            borderColor: '#3b82f6', 
                            backgroundColor: '#3b82f610', 
                            fill: true, 
                            tension: 0.4, 
                            borderWidth: 2, 
                            pointRadius: 2,
                            pointBackgroundColor: '#3b82f6'
                        },
                        { 
                            label: 'Pengeluaran',
                            data: {!! json_encode($chartTotalOut) !!}, 
                            borderColor: '#f43f5e', 
                            backgroundColor: '#f43f5e10', 
                            fill: true, 
                            tension: 0.4, 
                            borderWidth: 2, 
                            pointRadius: 2,
                            pointBackgroundColor: '#f43f5e'
                        }
                    ] 
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    plugins: { legend: { display: false } }, 
                    scales: { 
                        y: { display: false }, 
                        x: { 
                            grid: { display: false }, 
                            ticks: { font: { size: 9, weight: '600' }, color: '#94a3b8' } 
                        } 
                    } 
                }
            });

            // Pie Chart
            @if($pieData->count() > 0)
            new Chart(document.getElementById('pieChart'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($pieData->map(fn($i) => $i->category->name)) !!},
                    datasets: [{
                        data: {!! json_encode($pieData->pluck('total')) !!},
                        backgroundColor: ['#3b82f6', '#f43f5e', '#f59e0b', '#10b981', '#6366f1'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: { legend: { display: false } }
                }
            });
            @endif
        });
    </script>
    @endpush
</x-app-layout>
