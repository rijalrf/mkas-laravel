<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <title>{{ config('app.name', 'MKAS') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-tap-highlight-color: transparent; }
        </style>
    </head>
    <body class="bg-white text-slate-900 antialiased overflow-hidden">
        <div class="min-h-screen max-w-md mx-auto flex flex-col items-center justify-between p-10 py-20 relative">
            <!-- Decorative Background -->
            <div class="absolute -top-20 -left-20 w-64 h-64 bg-sky-50 rounded-full blur-3xl opacity-60"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-sky-100/30 rounded-full blur-[100px]"></div>
            
            <div class="relative z-10 flex flex-col items-center text-center space-y-8 mt-20">
                <div class="w-24 h-24 bg-sky-500 rounded-[40px] flex items-center justify-center text-white shadow-2xl shadow-sky-200 animate-bounce transition-all duration-1000">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" /><path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v14.25c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 19.125V4.875zM12 15.75a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" /><path d="M22.5 10.5a3 3 0 01-3 3V9a3 3 0 013 3zM1.5 10.5a3 3 0 003 3V9a3 3 0 00-3 3z" /></svg>
                </div>
                <div>
                    <h1 class="text-5xl font-black text-slate-900 tracking-tighter mb-4 italic leading-none">MKAS</h1>
                    <p class="text-[13px] font-extrabold text-slate-400 uppercase tracking-[0.4em] leading-relaxed">Manajemen Kas<br>Warga & Komunitas</p>
                </div>
            </div>

            <div class="relative z-10 w-full space-y-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block w-full py-5 bg-slate-900 text-white rounded-full text-center font-extrabold text-[11px] tracking-[0.3em] uppercase shadow-xl shadow-slate-100 active:scale-95 transition-all">Buka Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full py-5 bg-sky-500 text-white rounded-full text-center font-extrabold text-[11px] tracking-[0.3em] uppercase shadow-xl shadow-sky-100 active:scale-95 transition-all">Mulai Sekarang</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block w-full py-5 bg-white text-slate-400 rounded-full text-center font-extrabold text-[11px] tracking-[0.3em] uppercase border border-slate-50 active:scale-95 transition-all">Daftar Akun Baru</a>
                        @endif
                    @endauth
                @endif
                <p class="text-center text-[9px] font-extrabold text-slate-300 uppercase tracking-widest pt-4">Versi 2.0 • Modern & Clean</p>
            </div>
        </div>
    </body>
</html>
