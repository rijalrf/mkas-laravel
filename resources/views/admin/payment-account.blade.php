<x-app-layout>
    <x-slot name="title">Master Rekening</x-slot>

    <!-- FORM CARD -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <form action="{{ route('payment-accounts.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Bank Name -->
            <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Nama Bank</label>
                <input type="text" name="bank_name" value="{{ old('bank_name', $account->bank_name ?? '') }}" required placeholder="Contoh: Bank Mandiri" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 bg-gray-50 transition-all">
            </div>

            <!-- Bank Code -->
            <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Kode Bank</label>
                <input type="text" name="bank_code" value="{{ old('bank_code', $account->bank_code ?? '') }}" required placeholder="Contoh: 008" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 bg-gray-50 transition-all">
            </div>

            <!-- Account Number -->
            <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Nomor Rekening</label>
                <input type="text" name="account_number" value="{{ old('account_number', $account->account_number ?? '') }}" required placeholder="Contoh: 1234567890" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 bg-gray-50 transition-all">
            </div>

            <!-- Account Name -->
            <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Nama Pemilik Rekening</label>
                <input type="text" name="account_name" value="{{ old('account_name', $account->account_name ?? '') }}" required placeholder="Contoh: Bendahara MKAS" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 bg-gray-50 transition-all">
            </div>

            <!-- Monthly Amount -->
            <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Nominal Iuran Bulanan (Rp)</label>
                <input type="number" name="monthly_amount" value="{{ old('monthly_amount', $account->monthly_amount ?? '') }}" required placeholder="Contoh: 100000" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 bg-gray-50 transition-all">
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-lg font-bold text-sm shadow-md hover:bg-blue-700 active:scale-[0.98] transition-all uppercase tracking-widest">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</x-app-layout>
