<x-guest-layout>
    {{-- Background Layer --}}
    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-tr from-[#eef2ff] via-[#f4f6f9] to-[#e8f0ff] opacity-90"></div>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col px-6 py-8">
        
        {{-- Header Section --}}
        <div class="flex items-center justify-between mb-8 animate-rise">
            <x-application-logo />
            <a href="{{ route('register') }}" class="text-[11px] font-bold text-[#1a6bff] bg-[#e8f0ff] px-4 py-2 rounded-full uppercase tracking-wider">
                Daftar
            </a>
        </div>

        {{-- Judul --}}
        <div class="text-center mb-10 mt-4 animate-rise" style="animation-delay: 0.1s">
            <h2 class="text-3xl font-serif italic text-[#0d1117]">
                Login
            </h2>
            <p class="text-gray-500 text-xs mt-2">Masuk untuk mulai operasional</p>
        </div>

        {{-- Card Form --}}
        <div class="w-full max-w-md mx-auto bg-white border border-black/5 rounded-[2.5rem] p-8 shadow-xl shadow-blue-900/5 animate-rise" style="animation-delay: 0.2s">
            
            {{-- Tampilkan error dari session jika ada --}}
            @if ($errors->any())
                <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-xs">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5" id="loginForm">
                @csrf

                {{-- No HP / Plat Nomor --}}
                <div>
                    <label class="block text-[9px] font-bold uppercase tracking-wider text-gray-400 mb-1 ml-1">
                        No. HP / Plat Nomor
                    </label>
                    <input id="identifier" type="text" name="identifier" value="{{ old('identifier') }}" required autofocus
                        class="w-full rounded-xl bg-gray-50 border-0 py-3.5 px-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:ring-[#1a6bff]/30 focus:outline-none"
                        placeholder="Contoh: 0812xxx atau B1234XX">
                    <x-input-error :messages="$errors->get('identifier')" class="mt-1 text-xs" />
                </div>

                {{-- Kata Sandi dengan toggle --}}
                <div>
                    <label class="block text-[9px] font-bold uppercase tracking-wider text-gray-400 mb-1 ml-1">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full rounded-xl bg-gray-50 border-0 py-3.5 px-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:ring-[#1a6bff]/30 focus:outline-none pr-12"
                            placeholder="Masukkan kata sandi">
                        <button type="button" onclick="togglePassword()" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#1a6bff] transition">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                </div>

                {{-- Remember Me & Lupa Password --}}
                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#1a6bff] focus:ring-[#1a6bff]/30 focus:outline-none cursor-pointer" name="remember">
                        <span class="ml-2 text-xs text-gray-500 hover:text-gray-700 transition">Ingat Saya</span>
                    </label>

                    <button type="button" onclick="showForgotPasswordModal()" class="text-xs text-[#1a6bff] hover:text-[#0d5ae0] font-medium transition">
                        Lupa Password?
                    </button>
                </div>

                {{-- Tombol Login --}}
                <div class="pt-4">
                    <button type="submit" id="loginBtn" class="w-full bg-[#1a6bff] hover:bg-[#0d5ae0] text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-600/20 transform transition-all duration-200 active:scale-95 flex items-center justify-center gap-2 text-sm tracking-wide">
                        Masuk Sekarang
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>

                {{-- Link ke Register --}}
                <div class="text-center pt-2">
                    <p class="text-xs text-gray-400">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-[#1a6bff] font-bold hover:underline">Daftar Mitra Baru</a>
                    </p>
                </div>
            </form>
        </div>

        <footer class="mt-auto pt-8 pb-4 text-center">
            <p class="text-[9px] text-gray-400 uppercase tracking-widest">Driver Operational Portal</p>
        </footer>
    </div>

    {{-- Modal Lupa Password --}}
    <div id="forgotPasswordModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl w-full max-w-sm mx-4 p-6 shadow-2xl animate-rise">
            <div class="text-center mb-4">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-[#1a6bff]/10 rounded-full mb-3">
                    <svg class="w-6 h-6 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7.5a3.5 3.5 0 11-7 0 3.5 3.5 0 017 0zM5 18.5a8.5 8.5 0 0114 0"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Lupa Password?</h3>
                <p class="text-xs text-gray-500 mt-1">Masukkan email yang terdaftar</p>
                <p class="text-[10px] text-gray-400 mt-2">Link reset akan dikirim ke email Anda</p>
            </div>

            <form id="forgotPasswordForm" method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1 ml-1">
                        Alamat Email
                    </label>
                    <input type="email" name="email" id="resetEmail" required
                        class="w-full rounded-xl bg-gray-50 border-0 py-3.5 px-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:ring-[#1a6bff]/30 focus:outline-none"
                        placeholder="nama@email.com">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="hideForgotPasswordModal()" 
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-3 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" 
                        class="flex-1 bg-[#1a6bff] hover:bg-[#0d5ae0] text-white font-bold py-3 rounded-xl transition">
                        Kirim Link Reset
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }

        // Modal functions
        function showForgotPasswordModal() {
            document.getElementById('forgotPasswordModal').classList.remove('hidden');
            document.getElementById('forgotPasswordModal').classList.add('flex');
        }

        function hideForgotPasswordModal() {
            document.getElementById('forgotPasswordModal').classList.remove('flex');
            document.getElementById('forgotPasswordModal').classList.add('hidden');
            document.getElementById('forgotPasswordForm').reset();
        }

        // Close modal when clicking outside
        document.getElementById('forgotPasswordModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideForgotPasswordModal();
            }
        });
    </script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</x-guest-layout>