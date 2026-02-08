<x-app-layout>
    <div class="fixed top-0 inset-x-0 z-50 bg-[#0f172a] px-5 py-3 shadow-xl border-b border-slate-800 flex justify-between items-center">
        <div>
            <p class="text-blue-500 text-[10px] font-bold tracking-[0.2em] uppercase leading-tight">PT. CGS</p>
            <h1 class="text-white text-lg font-black tracking-tighter leading-none mt-0.5">UPLOAD BUKTI</h1>
        </div>
        <a href="{{ route('dashboard') }}" class="text-slate-400 text-xs font-bold">Batal</a>
    </div>

    <div class="h-16 bg-[#0f172a]"></div>

    <div class="p-5">
        <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-slate-100">
            <div class="bg-blue-50 p-4 border-b border-blue-100 text-center">
                <h3 class="text-blue-800 font-bold text-sm">📸 Foto Struk / Aplikasi</h3>
                <p class="text-xs text-blue-600">Sistem akan membaca otomatis lokasi & harga.</p>
            </div>
            
            <div class="p-6">
                {{-- Tampilkan Error jika ada --}}
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-3 rounded-xl text-xs mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('driver.ritase.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    {{-- Input File --}}
                    <label class="block w-full h-48 border-2 border-dashed border-blue-200 hover:border-blue-400 rounded-2xl flex flex-col items-center justify-center bg-blue-50/50 mb-6 cursor-pointer transition group relative overflow-hidden">
                        
                        {{-- Preview Image (Javascript nanti handle ini) --}}
                        <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden opacity-50">
                        
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-14 h-14 bg-white rounded-full shadow-sm flex items-center justify-center text-3xl group-hover:scale-110 transition mb-3">📂</div>
                            <span class="text-xs text-blue-600 font-bold" id="text-label">Klik untuk Upload Foto</span>
                        </div>
                        
                        <input type="file" name="foto_bukti" id="foto_bukti" required class="hidden" accept="image/*" 
                               onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0]); document.getElementById('preview').classList.remove('hidden'); document.getElementById('text-label').innerText = 'Ganti Foto';">
                    </label>

                    <button type="submit" class="w-full bg-[#0f172a] text-white font-bold py-4 rounded-xl shadow-lg shadow-slate-900/20 active:scale-95 transition flex items-center justify-center gap-2">
                        <span>KIRIM & SCAN OTOMATIS</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>