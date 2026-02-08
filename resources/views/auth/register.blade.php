<x-guest-layout>
    <div class="bg-slate-900 min-h-screen flex flex-col items-center justify-center p-6">
        
        <div class="text-center mb-6">
            <h2 class="text-2xl font-black text-white">DAFTAR MITRA</h2>
            <p class="text-slate-400 text-sm">Bergabung dengan PT CGS Trans</p>
        </div>

        <div class="w-full max-w-sm bg-white/10 backdrop-blur-lg border border-white/10 rounded-3xl p-6 shadow-2xl">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sky-200 text-xs font-bold uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="name" :value="old('name')" required autofocus 
                        class="w-full bg-slate-800/50 border border-slate-600 text-white rounded-xl px-4 py-3 focus:ring-sky-500 placeholder-slate-500" placeholder="Sesuai KTP/SIM">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400 text-xs" />
                </div>

                <div class="mb-4">
                    <label class="block text-sky-200 text-xs font-bold uppercase mb-1">Alamat Email</label>
                    <input type="email" name="email" :value="old('email')" required 
                        class="w-full bg-slate-800/50 border border-slate-600 text-white rounded-xl px-4 py-3 focus:ring-sky-500 placeholder-slate-500" placeholder="nama@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs" />
                </div>

                <div class="mb-4">
                    <label class="block text-sky-200 text-xs font-bold uppercase mb-1">No.Hp</label>
                    <input type="phone" name="phone" :value="old('phone')" required 
                        class="w-full bg-slate-800/50 border border-slate-600 text-white rounded-xl px-4 py-3 focus:ring-sky-500 placeholder-slate-500" placeholder="0812345678">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs" />
                </div>

                <div class="mb-4">
                    <label class="block text-sky-200 text-xs font-bold uppercase mb-1">Plat Nomor Kendaraan</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">🚗</span>
                        <input type="text" name="nopol" :value="old('nopol')" required 
                            class="w-full pl-10 bg-slate-800/50 border border-yellow-600/50 text-yellow-400 font-mono font-bold uppercase rounded-xl px-4 py-3 focus:ring-yellow-500 placeholder-slate-600" 
                            placeholder="B 1234 XXX">
                    </div>
                    <x-input-error :messages="$errors->get('nopol')" class="mt-2 text-red-400 text-xs" />
                </div>

                <div class="mb-4">
                    <label class="block text-sky-200 text-xs font-bold uppercase mb-1">Kata Sandi</label>
                    <input type="password" name="password" required 
                        class="w-full bg-slate-800/50 border border-slate-600 text-white rounded-xl px-4 py-3 focus:ring-sky-500" placeholder="Minimal 8 karakter">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs" />
                </div>

                <div class="mb-6">
                    <label class="block text-sky-200 text-xs font-bold uppercase mb-1">Konfirmasi Sandi</label>
                    <input type="password" name="password_confirmation" required 
                        class="w-full bg-slate-800/50 border border-slate-600 text-white rounded-xl px-4 py-3 focus:ring-sky-500" placeholder="Ulangi sandi">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400 text-xs" />
                </div>

                <button class="w-full bg-sky-600 hover:bg-sky-500 text-white font-bold py-4 rounded-xl shadow-lg transform active:scale-95 transition">
                    DAFTAR SEKARANG
                </button>

                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-slate-400 hover:text-white">
                        Sudah punya akun? <span class="text-sky-400 font-bold">Login</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>