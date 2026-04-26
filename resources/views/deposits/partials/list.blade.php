@foreach($deposits as $dp)
    @php
        $tagColors = [
            'APPROVED' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
            'REJECTED' => 'bg-rose-50 text-rose-600 border-rose-100',
            'PENDING' => 'bg-blue-50 text-blue-600 border-blue-100',
        ];
        $colorClass = $tagColors[$dp->status] ?? $tagColors['PENDING'];
    @endphp
    <a href="{{ route('deposits.show', $dp->id) }}" class="transaction-item p-4 flex items-center justify-between transition-all active:bg-gray-50">
        <!-- LEFT SIDE: Description and Meta -->
        <div class="flex flex-col gap-1 min-w-0 flex-1 text-left">
            <p class="text-sm font-semibold text-gray-800 truncate leading-tight">Iuran Bulan {{ \Carbon\Carbon::parse($dp->month)->translatedFormat('F Y') }}</p>
            <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">
                {{ $dp->user->name }} • {{ $dp->created_at->format('d M Y') }}
            </p>
        </div>

        <!-- RIGHT SIDE: Status and Amount -->
        <div class="flex flex-col items-end gap-2 shrink-0 ml-4">
            <span class="text-[8px] font-bold px-2 py-0.5 rounded-full uppercase tracking-widest border {{ $colorClass }}">
                {{ $dp->status }}
            </span>
            <p class="text-sm font-bold text-blue-600 leading-none">
                +{{ number_format($dp->amount, 0, ',', '.') }}
            </p>
        </div>
    </a>
@endforeach
