<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 animate-rise">
            <svg class="w-6 h-6 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <h2 class="font-serif italic text-xl font-bold text-gray-800">Edit Data Driver</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg border border-black/5 animate-rise">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800">Informasi Driver</h3>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1 ml-10">Perbarui data mitra driver</p>
                </div>

                <div class="p-6">
                    <form action="{{ route('drivers.update', $driver->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="space-y-5">
                            {{-- Foto Profil --}}
                            <div>
                                <label class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">
                                    Foto Profil
                                </label>
                                <div class="flex items-center gap-4">
                                    <div class="w-20 h-20 rounded-xl overflow-hidden border-2 border-gray-200 flex-shrink-0 bg-gray-50" id="photo-preview-wrapper">
                                        @if($driver->photo)
                                            <img id="photo-preview" src="{{ asset('storage/' . $driver->photo) }}" alt="Foto" class="w-full h-full object-cover">
                                        @else
                                            <div id="photo-placeholder" class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center font-bold text-[#1a6bff] text-2xl">
                                                {{ substr($driver->name, 0, 1) }}
                                            </div>
                                            <img id="photo-preview" src="" alt="Foto" class="w-full h-full object-cover hidden">
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <label for="photo-input" class="flex items-center gap-2 cursor-pointer bg-gray-50 border border-gray-200 hover:border-[#1a6bff] hover:bg-blue-50 text-gray-600 hover:text-[#1a6bff] font-semibold text-xs py-2.5 px-4 rounded-xl transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Pilih Foto Baru
                                        </label>
                                        <input id="photo-input" type="file" name="photo" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                                        <p class="text-[9px] text-gray-400 mt-1.5 ml-1">JPG, PNG, maks. 2MB. Kosongkan jika tidak ingin mengubah foto.</p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-1.5 ml-1">
                                    Nama Lengkap
                                </label>
                                <input type="text" name="name" value="{{ $driver->name }}" required 
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm focus:ring-2 focus:ring-[#1a6bff]/30 focus:border-[#1a6bff] bg-gray-50 transition">
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-1.5 ml-1">
                                    Email Login
                                </label>
                                <input type="email" name="email" value="{{ $driver->email }}" required 
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm focus:ring-2 focus:ring-[#1a6bff]/30 focus:border-[#1a6bff] bg-gray-50 transition">
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-1.5 ml-1">
                                    No. Handphone
                                </label>
                                <input type="tel" name="phone" value="{{ $driver->phone }}" required 
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm focus:ring-2 focus:ring-[#1a6bff]/30 focus:border-[#1a6bff] bg-gray-50 transition">
                            </div>

                            <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-200">
                                <label class="block text-[9px] font-bold text-yellow-700 uppercase tracking-wider mb-1.5 ml-1 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Plat Nomor Kendaraan
                                </label>
                                <input type="text" name="nopol" value="{{ $driver->nopol }}" required 
                                    class="w-full border border-yellow-300 rounded-xl px-4 py-3 text-gray-900 font-bold uppercase text-sm focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 bg-yellow-100/50 transition">
                                <p class="text-[9px] text-yellow-600 mt-1.5 ml-1">Ubah jika driver mengganti kendaraan</p>
                            </div>

                            <div class="border-t border-gray-100 pt-4 mt-2">
                                <label class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-1.5 ml-1 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                    Reset Password (Opsional)
                                </label>
                                <input type="password" name="password" placeholder="Isi hanya jika ingin mengganti password" 
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-gray-800 text-sm focus:ring-2 focus:ring-[#1a6bff]/30 focus:border-[#1a6bff] bg-gray-50 transition">
                                <p class="text-[9px] text-gray-400 mt-1.5 ml-1">Kosongkan jika tidak ingin mengubah password</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 mt-8 pt-2 border-t border-gray-100">
                            <a href="{{ route('drivers.index') }}" 
                                class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm rounded-xl transition">
                                Batal
                            </a>
                            <button type="submit" 
                                class="flex items-center gap-2 px-6 py-2.5 bg-[#1a6bff] hover:bg-[#0d5ae0] text-white font-bold text-sm rounded-xl shadow-md transition active:scale-95">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('photo-preview');
            const placeholder = document.getElementById('photo-placeholder');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</x-app-layout>