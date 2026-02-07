<x-guest-layout>
    <div class="bg-slate-900 min-h-screen flex flex-col items-center justify-center p-6">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-sky-500 to-blue-700 rounded-2xl shadow-lg mb-4 text-3xl">
                🚖
            </div>
            <h2 class="text-2xl font-black text-white">LOGIN DRIVER</h2>
            <p class="text-slate-400 text-sm">Masuk untuk mulai operasional</p>
        </div>

        <div class="w-full max-w-sm bg-white/10 backdrop-blur-lg border border-white/10 rounded-3xl p-8 shadow-2xl">
            
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-5">
                    <label for="email" class="block text-sky-200 text-xs font-bold uppercase mb-2">Email Driver</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                        class="w-full bg-slate-800/50 border border-slate-600 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 placeholder-slate-500 transition"
                        placeholder="nama@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs" />
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sky-200 text-xs font-bold uppercase mb-2">Kata Sandi</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" 
                        class="w-full bg-slate-800/50 border border-slate-600 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 placeholder-slate-500 transition"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs" />
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded bg-slate-700 border-slate-600 text-sky-500 focus:ring-sky-500" name="remember">
                        <span class="ml-2 text-sm text-slate-300">Ingat Saya</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a class="text-sm text-sky-400 hover:text-sky-300 font-bold" href="{{ route('password.request') }}">
                            Lupa sandi?
                        </a>
                    @endif
                </div>

                <button class="w-full bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-400 hover:to-blue-500 text-white font-bold py-4 rounded-xl shadow-lg transform active:scale-95 transition">
                    MASUK SEKARANG
                </button>

                <div class="mt-6 text-center">
                    <p class="text-slate-400 text-sm">Belum punya akun?</p>
                    <a href="{{ route('register') }}" class="text-sky-400 hover:text-white font-bold text-sm">
                        Daftar Mitra Baru
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>