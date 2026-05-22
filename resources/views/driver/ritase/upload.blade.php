<x-app-layout>
    {{-- Top Bar (Fixed) --}}
    <div class="fixed top-0 inset-x-0 z-50 bg-gradient-to-r from-[#1a6bff] to-[#0d5ae0] px-6 py-4 shadow-lg shadow-blue-900/20 flex justify-between items-center rounded-b-2xl">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="text-white/80 hover:text-white transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <p class="text-blue-100/80 text-[9px] font-bold tracking-[0.2em] uppercase leading-tight">PT CSG Trans</p>
                <h1 class="text-white text-lg font-serif italic leading-none mt-0.5">Upload Bukti</h1>
            </div>
        </div>
        <a href="{{ route('dashboard') }}" class="text-[10px] font-black text-white bg-red-500/80 hover:bg-red-600 px-4 py-1.5 rounded-full uppercase tracking-wider transition">Batal</a>
    </div>

    <div class="h-20"></div>

    <div class="px-5 pb-24">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-black/5 animate-rise">
            <div class="bg-blue-50 px-5 py-4 border-b border-blue-100">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-[#1a6bff] font-bold text-sm">Foto Bukti Perjalanan</h3>
                </div>
                <p class="text-[10px] text-gray-500 mt-1 ml-6">Upload foto struk atau bukti penyelesaian perjalanan</p>
            </div>

            <div class="p-6">
                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-xl text-xs mb-4 border border-red-100">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center gap-1">• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('driver.ritase.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <label class="block w-full min-h-[220px] border-2 border-dashed border-blue-200 hover:border-[#1a6bff] rounded-2xl flex flex-col items-center justify-center bg-blue-50/30 mb-6 cursor-pointer transition group relative overflow-hidden">

                        <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden opacity-60 group-hover:opacity-100 transition">

                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-14 h-14 bg-white rounded-xl shadow-sm flex items-center justify-center group-hover:scale-110 transition mb-3">
                                <svg class="w-6 h-6 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-xs text-gray-500 font-medium" id="text-label">Klik untuk upload foto</span>
                            <span class="text-[9px] text-gray-400 mt-1">Format JPG, PNG. Maks 2MB</span>
                        </div>

                        <input type="file" name="foto_bukti" id="foto_bukti" required class="hidden" accept="image/*"
                               onchange="
                                   const file = this.files[0];
                                   if (file) {
                                       if (file.size > 2 * 1024 * 1024) {
                                           alert('Ukuran foto terlalu besar. Maksimal 2MB.');
                                           this.value = '';
                                           return;
                                       }
                                       const reader = new FileReader();
                                       reader.onload = function(e) {
                                           const preview = document.getElementById('preview');
                                           preview.src = e.target.result;
                                           preview.classList.remove('hidden');
                                           document.getElementById('text-label').innerHTML = '✓ ' + file.name;
                                           document.getElementById('text-label').classList.add('text-green-600', 'font-bold');
                                       }
                                       reader.readAsDataURL(file);
                                   }
                               ">
                    </label>

                    <button type="submit" class="w-full bg-gradient-to-r from-[#1a6bff] to-[#0d5ae0] hover:from-[#0d5ae0] hover:to-[#1a6bff] text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-600/20 active:scale-95 transition flex items-center justify-center gap-2 text-sm uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Kirim & Proses
                    </button>
                </form>
            </div>
        </div>

        {{-- Informasi Tambahan --}}
        <div class="mt-6 bg-blue-50 rounded-xl p-4 border border-blue-100">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-[10px] font-bold text-[#1a6bff] uppercase tracking-wider">Informasi</p>
            </div>
            <p class="text-xs text-gray-600 leading-relaxed ml-6">
                Pastikan foto bukti terlihat jelas (nominal, tanggal, dan waktu) agar dapat diverifikasi oleh sistem.
            </p>
        </div>
    </div>
</x-app-layout>