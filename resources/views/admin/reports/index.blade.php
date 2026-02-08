<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            📈 Laporan & Koreksi Data
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- Filter Section --}}
            <div class="bg-white p-6 rounded-lg shadow-md mb-6 no-print">
                <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
                    <div class="w-full md:w-1/3">
                        <label class="font-bold text-gray-700">Dari Tanggal:</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div class="w-full md:w-1/3">
                        <label class="font-bold text-gray-700">Sampai Tanggal:</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div class="w-full md:w-1/3 flex gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow w-full">
                            🔍 Filter
                        </button>
                        <button type="button" onclick="window.print()" class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-6 rounded-lg shadow w-full">
                            🖨️ Cetak
                        </button>
                    </div>
                </form>
            </div>

            {{-- Table Section --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-blue-50 flex justify-between items-center">
                    <h3 class="font-bold text-lg text-blue-900">Hasil Pencarian</h3>
                    <div class="flex gap-2">
                        <span class="bg-green-200 text-green-800 px-3 py-1 rounded-full font-bold text-sm">
                             Total: Rp {{ number_format($ritases->sum('pendapatan'), 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-sm font-bold">
                            <tr>
                                <th class="px-6 py-3 border-b">Waktu</th>
                                <th class="px-6 py-3 border-b">Driver</th>
                                <th class="px-6 py-3 border-b">Tujuan (Final)</th>
                                <th class="px-6 py-3 border-b">Pendapatan</th>
                                <th class="px-6 py-3 border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse($ritases as $data)
                                <tr class="hover:bg-gray-50 border-b last:border-0">
                                    {{-- Waktu --}}
                                    <td class="px-6 py-4 font-mono text-sm">
                                        {{ $data->created_at->format('d/m/Y') }} <br>
                                        <span class="text-gray-400">{{ $data->created_at->format('H:i') }}</span>
                                    </td>

                                    {{-- Info Driver --}}
                                    <td class="px-6 py-4">
                                        <div class="font-bold">{{ $data->user->name }}</div>
                                        <div class="text-xs bg-gray-100 inline-block px-2 py-0.5 rounded border border-gray-200 mt-1">
                                            {{ $data->user->nopol }}
                                        </div>
                                    </td>

                                    {{-- Tujuan (Digabung) --}}
                                    <td class="px-6 py-4 max-w-xs truncate">
                                        @if($data->lokasi_tujuan)
                                            <span class="text-gray-800 font-medium">{{ Str::limit($data->lokasi_tujuan, 30) }}</span>
                                            <div class="text-xs text-green-600 italic">✅ Hasil Scan OCR</div>
                                        @else
                                            {{ $data->tujuan }}
                                            <div class="text-xs text-gray-400 italic">📝 Input Manual</div>
                                        @endif
                                    </td>

                                    {{-- Pendapatan --}}
                                    <td class="px-6 py-4 font-bold text-green-600">
                                        Rp {{ number_format($data->pendapatan, 0, ',', '.') }}
                                    </td>

                                    {{-- Tombol Edit / Lihat --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($data->foto_bukti)
                                            <button onclick="openEditModal(
                                                '{{ $data->id }}',
                                                '{{ asset('storage/'.$data->foto_bukti) }}', 
                                                '{{ $data->lokasi_jemput }}', 
                                                '{{ $data->lokasi_tujuan ?? $data->tujuan }}', 
                                                '{{ $data->pendapatan }}'
                                            )" 
                                            class="bg-blue-100 text-blue-600 px-3 py-1 rounded hover:bg-blue-200 transition text-sm font-bold flex items-center gap-1 mx-auto">
                                                👁️ Cek & Edit
                                            </button>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                        Tidak ada data.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- MODAL EDIT DATA (FORM) --}}
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity blur-sm" onclick="closeModal()"></div>

        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-5xl w-full">
                
                <form id="updateForm" method="POST" action="">
                    @csrf
                    @method('PUT')

                    {{-- Modal Header --}}
                    <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900">✏️ Verifikasi & Edit Data Ritase</h3>
                        <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-red-500 text-2xl font-bold">&times;</button>
                    </div>

                    {{-- Modal Body --}}
                    <div class="bg-white px-6 py-6">
                        <div class="md:flex gap-8">
                            
                            {{-- Kolom Kiri: Foto Bukti --}}
                            <div class="md:w-1/2 flex flex-col">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Bukti Foto Driver:</label>
                                <div class="bg-gray-100 rounded-lg border border-gray-300 p-2 flex items-center justify-center flex-grow">
                                    <img id="modalImage" src="" alt="Bukti Struk" class="max-h-[500px] w-auto rounded shadow-sm object-contain">
                                </div>
                                <p class="text-xs text-center text-gray-400 mt-2">Gunakan mouse scroll untuk zoom (browser native)</p>
                            </div>

                            {{-- Kolom Kanan: Form Edit --}}
                            <div class="md:w-1/2 space-y-5">
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 text-yellow-700 text-sm">
                                    ⚠️ <b>Perhatian Admin:</b> Cek foto di samping. Jika hasil scan salah, silakan ketik nominal/lokasi yang benar di bawah ini.
                                </div>

                                {{-- Input Pendapatan --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">💰 Pendapatan Bersih (Rp)</label>
                                    <input type="number" name="pendapatan" id="inputPendapatan" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-lg font-bold text-green-700">
                                </div>

                                {{-- Input Jemput --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">📍 Lokasi Jemput</label>
                                    <textarea name="lokasi_jemput" id="inputJemput" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>

                                {{-- Input Tujuan --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">🏁 Lokasi Tujuan</label>
                                    <textarea name="lokasi_tujuan" id="inputTujuan" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-2">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-2 bg-blue-600 text-base font-bold text-white hover:bg-blue-700 focus:outline-none sm:w-auto">
                            💾 Simpan Perubahan
                        </button>
                        <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-6 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script untuk Modal --}}
    <script>
        function openEditModal(id, imageSrc, jemput, tujuan, harga) {
            document.getElementById('modalImage').src = imageSrc;
            
            document.getElementById('inputPendapatan').value = harga || 0;
            document.getElementById('inputJemput').value = jemput || '';
            document.getElementById('inputTujuan').value = tujuan || '';

            let url = "{{ route('ritase.update.admin', 'ID_PLACEHOLDER') }}";
            document.getElementById('updateForm').action = url.replace('ID_PLACEHOLDER', id);

            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        document.onkeydown = function(evt) {
            if (evt.keyCode == 27) closeModal();
        };
    </script>

    {{-- Style Print --}}
    <style>
        @media print {
            .no-print, header, form, button, .bg-yellow-50 { display: none !important; }
            body { background: white !important; }
            .shadow-lg, .shadow-md { box-shadow: none !important; border: 1px solid #ddd; }
        }
    </style>
</x-app-layout>