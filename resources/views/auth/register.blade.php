<x-guest-layout>
    <div class="bg-slate-900 min-h-screen flex flex-col items-center justify-center p-6">
        
        <div class="text-center mb-6 mt-8">
            <h2 class="text-2xl font-black text-white">DAFTAR MITRA</h2>
            <p class="text-slate-400 text-sm">Bergabung dengan PT CSG Trans</p>
        </div>

        <div class="w-full max-w-sm bg-white/10 backdrop-blur-lg border border-white/10 rounded-3xl p-6 shadow-2xl mb-8">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-5 text-center">
                    <label class="block text-sky-200 text-xs font-bold uppercase mb-3">Foto Wajah (Selfie)</label>
                    
                    <div class="relative w-32 h-32 mx-auto mb-2 group">
                        <div id="image-preview-container" class="w-full h-full rounded-2xl border-2 border-dashed border-sky-400/50 bg-slate-800/50 flex flex-col items-center justify-center overflow-hidden cursor-pointer hover:border-sky-400 transition" onclick="document.getElementById('photo').click()">
                            <div id="upload-icon" class="text-center">
                                <span class="text-3xl">📸</span>
                                <p class="text-[10px] text-sky-300 mt-1">Ambil Foto</p>
                            </div>
                            <img id="photo-preview" src="" class="hidden w-full h-full object-cover absolute top-0 left-0" alt="Preview">
                        </div>
                    </div>
                    
                    <input type="file" id="photo" name="photo" accept="image/*" capture="user" required class="hidden" onchange="previewImage(event)">
                    
                    <x-input-error :messages="$errors->get('photo')" class="mt-2 text-red-400 text-xs text-center" />
                    <p class="text-[10px] text-slate-400 mt-1">Wajib foto wajah yang jelas terang</p>
                </div>
                
                <hr class="border-slate-700 mb-5">

                <div class="mb-4">
                    <label class="block text-sky-200 text-xs font-bold uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="name" :value="old('name')" required 
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
                    <input type="tel" name="phone" :value="old('phone')" required 
                        class="w-full bg-slate-800/50 border border-slate-600 text-white rounded-xl px-4 py-3 focus:ring-sky-500 placeholder-slate-500" placeholder="0812345678">
                    <x-input-error :messages="$errors->get('phone')" class="mt-2 text-red-400 text-xs" />
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

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('photo-preview');
                var icon = document.getElementById('upload-icon');
                
                output.src = reader.result;
                output.classList.remove('hidden');
                icon.classList.add('hidden');
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-guest-layout>