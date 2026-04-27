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
                <div class="space-y-2" x-data="{ show: false }">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Password</label>
                    <div class="relative group">
                        <input :type="show ? 'text' : 'password'" name="password" required 
                            class="w-full pl-6 pr-14 py-4 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-gray-300">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 w-14 flex items-center justify-center text-gray-400 hover:text-blue-600 transition-colors focus:outline-none">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.399 8.049 7.21 5 12 5c4.789 0 8.601 3.049 9.964 6.678a1.012 1.012 0 010 .644C20.601 15.951 16.79 19 12 19c-4.789 0-8.601-3.049-9.964-6.678z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" x-cloak><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                        </button>
                    </div>
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
