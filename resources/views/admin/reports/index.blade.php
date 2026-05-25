<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h2 class="font-serif italic text-xl font-bold text-gray-800">Laporan & Koreksi Data</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm animate-rise" role="alert">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="font-bold">Berhasil!</p>
                    </div>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Filter Section --}}
            <div class="bg-white rounded-2xl shadow-md border border-black/5 p-6 no-print animate-rise">
                <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
                    <div class="w-full md:w-1/3">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-[#1a6bff] focus:ring focus:ring-blue-100 transition">
                    </div>
                    <div class="w-full md:w-1/3">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-[#1a6bff] focus:ring focus:ring-blue-100 transition">
                    </div>
                    <div class="flex items-center gap-3 flex-wrap">
                        {{-- Filter --}}
                        <button type="submit"
                            class="flex items-center justify-center gap-2 bg-[#1a6bff] hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition no-print">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                            </svg>
                            Filter
                        </button>
                        {{-- Cetak --}}
                        <button type="button" onclick="window.print()"
                            class="flex items-center justify-center gap-2 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition no-print">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak
                        </button>
                        {{-- Excel --}}
                        <button type="submit" name="export" value="excel"
                            class="flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition no-print">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Excel
                        </button>
                    </div>
                </form>
            </div>

            {{-- Table Section --}}
            <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-black/5 animate-rise">
                <div class="px-6 py-4 border-b border-gray-100 bg-blue-50/30 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Hasil Pencarian
                    </h3>
                    <div class="flex gap-2">
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-bold text-xs">
                            Total: Rp {{ number_format($ritases->sum('pendapatan'), 0, ',', '.') }}
                        </span>
                        <span class="bg-blue-100 text-[#1a6bff] px-3 py-1 rounded-full font-bold text-xs">
                            {{ $totalRitase }} Ritase
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-400 uppercase text-[9px] font-bold tracking-wider border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Jam</th>
                                <th class="px-6 py-3">Driver</th>
                                <th class="px-6 py-3">Lokasi Jemput</th>
                                <th class="px-6 py-3">Lokasi Tujuan</th>
                                <th class="px-6 py-3 text-right">Pendapatan</th>
                                <th class="px-6 py-3 text-center no-print">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($ritases as $data)
                                <tr class="hover:bg-blue-50/20 transition">
                                    <td class="px-6 py-4 font-semibold text-gray-700">
                                        {{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ \Carbon\Carbon::parse($data->created_at)->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-700">{{ $data->user->name ?? '-' }}</div>
                                        <div class="text-[10px] font-mono text-gray-400 mt-0.5">{{ $data->user->nopol ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 max-w-[160px] truncate">{{ $data->lokasi_jemput ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-600 max-w-[160px] truncate">{{ $data->lokasi_tujuan ?? $data->tujuan ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right font-bold text-green-600">
                                        Rp {{ number_format($data->pendapatan, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center no-print">
                                        <div class="flex items-center justify-center gap-2">
                                            @if($data->foto_bukti)
                                                <button onclick="openEditModal(
                                                    '{{ $data->id }}',
                                                    '{{ asset('storage/'.$data->foto_bukti) }}',
                                                    '{{ addslashes($data->lokasi_jemput) }}',
                                                    '{{ addslashes($data->lokasi_tujuan ?? $data->tujuan) }}',
                                                    '{{ $data->pendapatan }}',
                                                    '{{ \Carbon\Carbon::parse($data->created_at)->format('Y-m-d\TH:i') }}'
                                                )"
                                                class="inline-flex items-center gap-1 bg-blue-50 text-[#1a6bff] hover:bg-blue-100 px-3 py-1.5 rounded-lg transition text-xs font-bold">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Cek & Edit
                                                </button>
                                            @endif

                                            {{-- Tombol Hapus — selalu tampil --}}
                                            <button
                                                onclick="confirmDelete(
                                                    {{ $data->id }},
                                                    '{{ addslashes($data->user->name ?? 'driver ini') }}',
                                                    '{{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y H:i') }}'
                                                )"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg transition">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2 text-gray-400">
                                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                            <p class="text-sm">Tidak ada data</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- Modal Edit Ritase --}}
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm" onclick="closeModal()"></div>

        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl sm:max-w-5xl w-full animate-rise">

                <form id="updateForm" method="POST" action="">
                    @csrf
                    @method('PUT')

                    {{-- Header Modal --}}
                    <div class="bg-gradient-to-r from-[#1a6bff] to-[#0d5ae0] px-6 py-4 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <h3 class="text-lg font-bold text-white">Verifikasi & Edit Data Ritase</h3>
                        </div>
                        <button type="button" onclick="closeModal()" class="text-white/80 hover:text-white text-2xl font-bold leading-none">&times;</button>
                    </div>

                    <div class="bg-white px-6 py-6">
                        <div class="md:flex gap-8">

                            {{-- Foto --}}
                            <div class="md:w-1/2 mb-6 md:mb-0">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Bukti Foto Driver</label>
                                <div class="bg-gray-50 rounded-xl border border-gray-200 p-4 flex items-center justify-center min-h-[300px]">
                                    <img id="modalImage" src="" alt="Bukti Struk" class="max-h-[400px] w-auto rounded-lg shadow-sm object-contain">
                                </div>
                            </div>

                            {{-- Form Edit --}}
                            <div class="md:w-1/2 space-y-4">
                                <div class="bg-yellow-50 rounded-xl border-l-4 border-yellow-400 p-3 text-yellow-700 text-xs">
                                    <div class="flex items-center gap-2 mb-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <b>Perhatian Admin</b>
                                    </div>
                                    <p>Cek foto di samping. Jika hasil scan salah, koreksi data di bawah ini.</p>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal & Jam Orderan</label>
                                    <input type="datetime-local" name="tanggal_waktu" id="inputTanggalWaktu"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-[#1a6bff] focus:border-[#1a6bff] bg-gray-50 text-sm">
                                    <p class="text-[10px] text-gray-400 mt-1">Kosongkan jika tidak perlu diubah</p>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Pendapatan Bersih (Rp)</label>
                                    <input type="number" name="pendapatan" id="inputPendapatan"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-[#1a6bff] focus:border-[#1a6bff] bg-gray-50 text-lg font-bold text-green-600">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Lokasi Jemput</label>
                                    <textarea name="lokasi_jemput" id="inputJemput" rows="2"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-[#1a6bff] focus:border-[#1a6bff] bg-gray-50 text-sm"></textarea>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Lokasi Tujuan</label>
                                    <textarea name="lokasi_tujuan" id="inputTujuan" rows="2"
                                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-[#1a6bff] focus:border-[#1a6bff] bg-gray-50 text-sm"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-gray-100">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl px-6 py-2.5 bg-[#1a6bff] text-white font-bold hover:bg-[#0d5ae0] transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Simpan Perubahan
                        </button>
                        <button type="button" onclick="closeModal()"
                            class="inline-flex justify-center rounded-xl border border-gray-300 px-6 py-2.5 bg-white text-gray-700 font-medium hover:bg-gray-50 transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm" onclick="closeDeleteModal()"></div>

        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md animate-rise">

                {{-- Header --}}
                <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4 rounded-t-2xl flex items-center gap-3">
                    <div class="bg-white/20 rounded-full p-2">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white">Konfirmasi Hapus Data</h3>
                </div>

                {{-- Body --}}
                <div class="px-6 py-5">
                    <p class="text-gray-600 text-sm">Anda akan menghapus data ritase:</p>
                    <div class="mt-3 bg-red-50 border border-red-100 rounded-xl p-4 space-y-1">
                        <p class="text-sm font-bold text-gray-800" id="deleteDriverName">-</p>
                        <p class="text-xs text-gray-500" id="deleteDateTime">-</p>
                    </div>
                    <p class="mt-4 text-xs text-red-600 font-semibold">
                        ⚠️ Tindakan ini tidak dapat dibatalkan. Data akan dihapus permanen beserta foto buktinya.
                    </p>
                </div>

                {{-- Footer --}}
                <div class="px-6 pb-5 flex justify-end gap-3">
                    <button
                        onclick="closeDeleteModal()"
                        class="px-5 py-2 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                        Batal
                    </button>

                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-5 py-2 text-sm font-bold text-white bg-red-500 hover:bg-red-600 rounded-xl transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Ya, Hapus Data
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        function openEditModal(id, imageSrc, jemput, tujuan, harga, tanggalWaktu) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('inputPendapatan').value = harga || 0;
            document.getElementById('inputJemput').value = jemput || '';
            document.getElementById('inputTujuan').value = tujuan || '';
            document.getElementById('inputTanggalWaktu').value = tanggalWaktu || '';

            let url = "{{ route('ritase.update.admin', 'ID_PLACEHOLDER') }}";
            document.getElementById('updateForm').action = url.replace('ID_PLACEHOLDER', id);

            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function confirmDelete(id, driverName, dateTime) {
            document.getElementById('deleteDriverName').textContent = 'Driver: ' + driverName;
            document.getElementById('deleteDateTime').textContent   = 'Tanggal: ' + dateTime;
            document.getElementById('deleteForm').action = '/ritase/' + id + '/destroy';
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        document.onkeydown = function(evt) {
            if (evt.keyCode === 27) {
                closeModal();
                closeDeleteModal();
            }
        };
    </script>

    <style>
        @media print {
            .no-print, header, nav { display: none !important; }
            body { background: white !important; }
            .shadow-lg, .shadow-md { box-shadow: none !important; border: 1px solid #ddd; }
        }
    </style>
</x-app-layout>