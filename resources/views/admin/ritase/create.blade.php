<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            📝 Input Surat Jalan (Ritase)
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-2xl mx-auto px-4">
            
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-indigo-600 px-6 py-4 border-b border-indigo-500">
                    <h3 class="text-white font-bold text-lg">Detail Pengantaran</h3>
                    <p class="text-indigo-200 text-sm">Pastikan data driver sudah sesuai.</p>
                </div>

                <form action="{{ route('ritase.store') }}" method="POST" class="p-8">
                    @csrf
                    <input type="hidden" name="queue_id" value="{{ $queue->id }}">

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="text-xs font-bold text-gray-500 uppercase">Nama Driver</label>
                            <p class="font-bold text-gray-800 text-lg">{{ $queue->user->name }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="text-xs font-bold text-gray-500 uppercase">Plat Nomor</label>
                            <p class="font-bold text-gray-800 text-lg font-mono">{{ $queue->user->nopol }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold text-gray-700 mb-2">📍 Tujuan</label>
                        <input type="text" name="tujuan" required placeholder="Contoh: Depok" 
                            class="w-full border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition p-3">
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold text-gray-700 mb-2">Catatan</label>
                        <textarea name="keterangan" rows="3" placeholder="Contoh: Semen 500 Sak, Hati-hati barang pecah belah..." 
                            class="w-full border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition p-3"></textarea>
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('dashboard') }}" class="w-1/3 text-center text-gray-500 font-bold hover:text-gray-700 transition">
                            Batal
                        </a>
                        <button type="submit" class="w-2/3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg transform active:scale-95 transition flex justify-center items-center gap-2">
                            🚀 PROSES JALAN
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>