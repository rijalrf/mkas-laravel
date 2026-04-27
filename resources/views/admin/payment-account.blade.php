<x-app-layout>
    <x-slot name="title">Master Rekening</x-slot>

    <!-- FORM CARD -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <form action="{{ route('payment-accounts.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Bank Name -->
            <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Nama Bank</label>
                <input type="text" name="bank_name" value="{{ old('bank_name', $account->bank_name ?? '') }}" required maxlength="255" placeholder="Contoh: Bank Mandiri" 
                    class="w-full px-4 py-3 border @error('bank_name') border-rose-500 @else border-gray-300 @enderror rounded-lg text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 bg-gray-50 transition-all">
                @error('bank_name')
                    <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bank Code -->
            <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Kode Bank</label>
                <input type="text" name="bank_code" value="{{ old('bank_code', $account->bank_code ?? '') }}" required maxlength="10" placeholder="Contoh: 008" 
                    class="w-full px-4 py-3 border @error('bank_code') border-rose-500 @else border-gray-300 @enderror rounded-lg text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 bg-gray-50 transition-all">
                @error('bank_code')
                    <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Account Number -->
            <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Nomor Rekening</label>
                <input type="text" name="account_number" value="{{ old('account_number', $account->account_number ?? '') }}" required maxlength="50" placeholder="Contoh: 1234567890" 
                    class="w-full px-4 py-3 border @error('account_number') border-rose-500 @else border-gray-300 @enderror rounded-lg text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 bg-gray-50 transition-all">
                @error('account_number')
                    <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Account Name -->
            <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Nama Pemilik Rekening</label>
                <input type="text" name="account_name" value="{{ old('account_name', $account->account_name ?? '') }}" required maxlength="255" placeholder="Contoh: Bendahara MKAS" 
                    class="w-full px-4 py-3 border @error('account_name') border-rose-500 @else border-gray-300 @enderror rounded-lg text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 bg-gray-50 transition-all">
                @error('account_name')
                    <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Monthly Amount -->
            <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Nominal Iuran Bulanan (Rp)</label>
                <input type="number" name="monthly_amount" value="{{ old('monthly_amount', $account->monthly_amount ?? '') }}" required min="0" placeholder="Contoh: 100000" 
                    class="w-full px-4 py-3 border @error('monthly_amount') border-rose-500 @else border-gray-300 @enderror rounded-lg text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 bg-gray-50 transition-all">
                @error('monthly_amount')
                    <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-lg font-bold text-sm shadow-md hover:bg-blue-700 active:scale-[0.98] transition-all uppercase tracking-widest">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</x-app-layout>
