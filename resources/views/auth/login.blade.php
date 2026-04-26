<x-guest-layout>
    <div class="min-h-screen bg-white flex flex-col justify-center px-10 py-10">
        <div class="max-w-md w-full mx-auto space-y-12">
            <!-- Header Section -->
            <div class="space-y-2">
                <h2 class="text-3xl font-black text-gray-900 tracking-tighter leading-none">Selamat Datang.</h2>
                <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-[0.2em] leading-none">Kelola Kas Anda dengan Mudah</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <!-- Force Remember Me (Hidden) -->
                <input type="hidden" name="remember" value="1">

                <!-- Email Address -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Email</label>
                    <input type="email" name="email" :value="old('email')" required autofocus 
                        class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-gray-300">
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Password</label>
                    <input type="password" name="password" required 
                        class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-gray-300">
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div class="pt-6 space-y-6 text-center">
                    <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-xl font-extrabold text-xs tracking-[0.2em] shadow-xl shadow-blue-100 uppercase active:scale-[0.98] transition-all">
                        Masuk Sekarang
                    </button>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                        Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 font-black">Daftar Akun</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
