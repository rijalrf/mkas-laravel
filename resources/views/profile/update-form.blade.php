<x-app-layout>
    <x-slot name="title">Ubah Profil</x-slot>

    <!-- UPDATE FORM CARD -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-8">
        <!-- Photo Upload Section -->
        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('patch')

            <div class="flex flex-col items-center gap-4 py-4">
                <div class="relative">
                    <div class="w-24 h-24 rounded-full bg-blue-50 overflow-hidden border-4 border-white shadow-md ring-1 ring-gray-100">
                        @if(Auth::user()->photo)
                            <img id="avatar-preview" src="{{ asset('storage/'.Auth::user()->photo) }}" class="w-full h-full object-cover">
                        @else
                            <img id="avatar-preview" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0ea5e9&color=fff&size=200" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <label for="photo-input" class="absolute bottom-0 right-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center border-2 border-white shadow-lg cursor-pointer active:scale-90 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" /></svg>
                        <input type="file" id="photo-input" name="photo" class="hidden" accept="image/*">
                    </label>
                </div>
                <div class="text-center">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Ketuk ikon kamera untuk ubah foto</p>
                </div>
            </div>

            <hr class="border-gray-50">

            <!-- Data Inputs -->
            <div class="space-y-4">
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 bg-gray-50">
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 bg-gray-50">
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-xl font-bold text-sm shadow-md hover:bg-blue-700 active:scale-[0.98] transition-all uppercase tracking-widest">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- UPDATE PASSWORD CARD -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-6">
        <div class="flex items-center gap-3 px-1">
            <div class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
            </div>
            <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Keamanan Akun</h4>
        </div>
        
        <form method="post" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('put')

            <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Password Saat Ini</label>
                <input type="password" name="current_password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm bg-gray-50 focus:ring-2 focus:ring-blue-500">
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
            </div>

            <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Password Baru</label>
                <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm bg-gray-50 focus:ring-2 focus:ring-blue-500">
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
            </div>

            <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm bg-gray-50 focus:ring-2 focus:ring-blue-500">
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3.5 border border-amber-500 text-amber-600 rounded-lg font-bold text-sm hover:bg-amber-50 transition-all active:scale-[0.98] uppercase tracking-widest">
                    Ganti Password
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.getElementById('photo-input').onchange = evt => {
            const [file] = document.getElementById('photo-input').files
            if (file) {
                document.getElementById('avatar-preview').src = URL.createObjectURL(file)
            }
        }
    </script>
    @endpush
</x-app-layout>
