<x-guest-layout>
    {{-- Background Layer --}}
    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-tr from-[#eef2ff] via-[#f4f6f9] to-[#e8f0ff] opacity-90"></div>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col px-6 py-8">
        
        {{-- Header Section --}}
        <div class="flex items-center justify-between mb-8 animate-rise">
            <x-application-logo />
            <a href="{{ route('login') }}" class="text-[11px] font-bold text-[#1a6bff] bg-[#e8f0ff] px-4 py-2 rounded-full uppercase tracking-wider">
                Login
            </a>
        </div>

        {{-- Judul --}}
        <div class="text-center mb-8 mt-2 animate-rise" style="animation-delay: 0.1s">
            <h2 class="text-3xl font-serif italic text-[#0d1117]">
                Daftar <span class="text-[#1a6bff] font-serif italic">Mitra.</span>
            </h2>
            <p class="text-gray-500 text-xs mt-2">Lengkapi data operasional kendaraan Anda</p>
        </div>

        {{-- Card Form --}}
        <div class="w-full max-w-md mx-auto bg-white border border-black/5 rounded-[2.5rem] p-8 shadow-xl shadow-blue-900/5 animate-rise" style="animation-delay: 0.2s">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- Profile Photo Upload --}}
                <div class="text-center">
                    <label class="block text-[10px] font-bold uppercase tracking-[0.15em] text-[#1a6bff] mb-3">
                        Foto Wajah
                    </label>
                    
                    <div class="relative w-28 h-28 mx-auto mb-2 group">
                        <div id="image-preview-container" 
                             class="w-full h-full rounded-2xl border-2 border-dashed border-blue-200 bg-blue-50/50 flex flex-col items-center justify-center overflow-hidden cursor-pointer hover:border-[#1a6bff] hover:bg-blue-50 transition-all" 
                             onclick="document.getElementById('photo').click()">
                            
                            <div id="upload-icon" class="text-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                </svg>
                                <p class="text-[9px] font-bold uppercase tracking-wider">Upload</p>
                            </div>
                            <img id="photo-preview" src="" class="hidden w-full h-full object-cover absolute top-0 left-0" alt="Preview">
                        </div>
                    </div>
                    <input type="file" id="photo" name="photo" accept="image/*" capture="user" required class="hidden" onchange="previewImage(event)">
                    <p class="text-[9px] text-gray-400 mt-1">Foto selfie wajah jelas terang</p>
                    <x-input-error :messages="$errors->get('photo')" class="mt-1 text-xs" />
                </div>

                <div class="h-[1px] bg-black/5 w-full my-4"></div>

                {{-- Input Fields --}}
                <div class="space-y-4">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-wider text-gray-400 mb-1 ml-1">
                            Nama Lengkap
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full rounded-xl bg-gray-50 border-0 py-3.5 px-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:ring-[#1a6bff]/30 focus:outline-none"
                            placeholder="Sesuai KTP/SIM">
                        <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
                    </div>

                    {{-- No Handphone --}}
                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-wider text-gray-400 mb-1 ml-1">
                            No. Handphone
                        </label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required
                            class="w-full rounded-xl bg-gray-50 border-0 py-3.5 px-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:ring-[#1a6bff]/30 focus:outline-none"
                            placeholder="0812345678">
                        <x-input-error :messages="$errors->get('phone')" class="mt-1 text-xs" />
                    </div>

                    {{-- Plat Nomor --}}
                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-wider text-gray-400 mb-1 ml-1">
                            Plat Nomor Kendaraan
                        </label>
                        <input type="text" name="nopol" value="{{ old('nopol') }}" required
                            class="w-full rounded-xl bg-gray-50 border-0 py-3.5 px-4 text-sm font-mono font-bold text-[#1a6bff] uppercase placeholder:text-gray-300 focus:ring-2 focus:ring-[#1a6bff]/30 focus:outline-none"
                            placeholder="B 1234 XXX">
                        <x-input-error :messages="$errors->get('nopol')" class="mt-1 text-xs" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-wider text-gray-400 mb-1 ml-1">
                            Alamat Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full rounded-xl bg-gray-50 border-0 py-3.5 px-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:ring-[#1a6bff]/30 focus:outline-none"
                            placeholder="nama@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                    </div>

                    {{-- Kata Sandi --}}
                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-wider text-gray-400 mb-1 ml-1">
                            Kata Sandi
                        </label>
                        <input type="password" name="password" required
                            class="w-full rounded-xl bg-gray-50 border-0 py-3.5 px-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:ring-[#1a6bff]/30 focus:outline-none"
                            placeholder="Minimal 8 karakter">
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                    </div>

                    {{-- Konfirmasi Sandi --}}
                    <div>
                        <label class="block text-[9px] font-bold uppercase tracking-wider text-gray-400 mb-1 ml-1">
                            Konfirmasi Kata Sandi
                        </label>
                        <input type="password" name="password_confirmation" required
                            class="w-full rounded-xl bg-gray-50 border-0 py-3.5 px-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:ring-[#1a6bff]/30 focus:outline-none"
                            placeholder="Ulangi kata sandi">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs" />
                    </div>
                </div>

                {{-- Tombol Daftar --}}
                <div class="pt-4">
                    <button type="submit" class="w-full bg-[#1a6bff] hover:bg-[#0d5ae0] text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-600/20 transform transition-all duration-200 active:scale-95 flex items-center justify-center gap-2 text-sm tracking-wide">
                        Daftar Sekarang
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>

                {{-- Link ke Login --}}
                <div class="text-center pt-2">
                    <p class="text-xs text-gray-400">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-[#1a6bff] font-bold hover:underline">Login</a>
                    </p>
                </div>
            </form>
        </div>

        <footer class="mt-auto pt-8 pb-4 text-center">
            <p class="text-[9px] text-gray-400 uppercase tracking-widest">Official Registration Portal</p>
        </footer>
    </div>

    <script>
        function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;

    const maxSize = 5 * 1024 * 1024; // 5MB
    if (file.size > maxSize) {
        alert('Ukuran foto terlalu besar. Maksimal 5MB.');
        event.target.value = ''; // reset input
        return;
    }

    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('photo-preview');
        const icon = document.getElementById('upload-icon');
        output.src = reader.result;
        output.classList.remove('hidden');
        icon.classList.add('hidden');
        output.parentElement.classList.add('border-[#1a6bff]', 'border-solid');
    }
    reader.readAsDataURL(file);
}
    </script>
</x-guest-layout>