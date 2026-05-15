<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 animate-rise">
            <svg class="w-6 h-6 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h2 class="font-serif italic text-xl font-bold text-gray-800">Riwayat Absensi</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm animate-rise">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="font-bold text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm animate-rise">
                    <p class="font-bold text-sm">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Filter + Export --}}
            <div class="bg-white rounded-2xl shadow-md border border-black/5 p-5 animate-rise">
                <form action="{{ route('admin.attendance.index') }}" method="GET"
                    class="flex flex-col md:flex-row items-end justify-between gap-4">
                    <div>
                        <label class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-1.5 ml-1">Filter Tanggal</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <input type="date" name="date" value="{{ request('date') }}"
                                class="pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-[#1a6bff] focus:ring focus:ring-blue-100 transition">
                        </div>
                    </div>

                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="bg-blue-50 text-[#1a6bff] px-3 py-1.5 rounded-full font-bold text-[10px]">
                            Total: {{ $attendances->total() }} absensi
                        </span>
                        <button type="submit"
                            class="flex items-center gap-2 bg-[#1a6bff] hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-md transition text-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                            </svg>
                            Filter
                        </button>
                        <a href="{{ route('admin.attendance.index', array_merge(request()->query(), ['export' => 'excel'])) }}"
                            class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-md transition text-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export Excel
                        </a>
                    </div>
                </form>
            </div>

            {{-- Tabel --}}
            <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-black/5 animate-rise">
                <div class="px-5 py-3.5 border-b border-gray-100 bg-blue-50/30 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Daftar Absensi Driver
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-400 uppercase text-[9px] font-bold tracking-wider border-b border-gray-100">
                            <tr>
                                <th class="px-5 py-3">Tanggal</th>
                                <th class="px-5 py-3">Nama Driver</th>
                                <th class="px-5 py-3">Plat Nomor</th>
                                <th class="px-5 py-3">Jam Absen</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3 text-center">Bukti Foto</th>
                                <th class="px-5 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($attendances as $absen)
                                <tr class="hover:bg-blue-50/20 transition">
                                    {{-- Tanggal --}}
                                    <td class="px-5 py-3.5">
                                        <span class="text-sm font-semibold text-gray-700">
                                            {{ \Carbon\Carbon::parse($absen->date)->format('d M Y') }}
                                        </span>
                                    </td>

                                    {{-- Nama Driver --}}
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span class="text-[10px] font-black text-[#1a6bff]">
                                                    {{ strtoupper(substr($absen->user->name ?? 'D', 0, 1)) }}
                                                </span>
                                            </div>
                                            <span class="text-sm font-semibold text-gray-700">{{ $absen->user->name ?? '-' }}</span>
                                        </div>
                                    </td>

                                    {{-- Plat Nomor --}}
                                    <td class="px-5 py-3.5">
                                        <span class="font-mono text-xs font-bold bg-gray-100 px-2.5 py-1 rounded-lg text-gray-600">
                                            {{ $absen->user->nopol ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- Jam Absen --}}
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-sm text-gray-700 font-semibold">{{ $absen->created_at->format('H:i') }} WIB</span>
                                        </div>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-5 py-3.5">
                                        @if($absen->status == 'verified')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-700">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                Terverifikasi
                                            </span>
                                        @elseif($absen->status == 'rejected')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-700">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                Ditolak
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-700">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Menunggu
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Bukti Foto --}}
                                    <td class="px-5 py-3.5 text-center">
                                        @if($absen->payment_proof)
                                            <a href="{{ asset('storage/' . $absen->payment_proof) }}" target="_blank"
                                                class="inline-flex items-center gap-1.5 bg-blue-50 text-[#1a6bff] hover:bg-[#1a6bff] hover:text-white px-3 py-1.5 rounded-lg transition text-xs font-bold">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Lihat Foto
                                            </a>
                                        @else
                                            <span class="text-[10px] text-gray-400 italic">-</span>
                                        @endif
                                    </td>

                                    {{-- Aksi: Edit Jam + Tolak --}}
                                    <td class="px-5 py-3.5 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Tombol Edit Jam --}}
                                            @if($absen->status != 'rejected')
                                                <button
                                                    onclick="openEditJam('{{ $absen->id }}', '{{ $absen->created_at->format('H:i') }}')"
                                                    class="inline-flex items-center gap-1 bg-amber-50 text-amber-600 hover:bg-amber-100 px-2.5 py-1.5 rounded-lg transition text-xs font-bold"
                                                    title="Edit Jam">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Edit Jam
                                                </button>
                                            @endif

                                            {{-- Tombol Tolak --}}
                                            @if($absen->status != 'rejected')
                                                <form action="{{ route('attendance.reject', $absen->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin tolak absensi {{ $absen->user->name ?? 'driver' }} ini? Antrian aktifnya juga akan dibatalkan dan driver harus upload ulang.')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1 bg-red-50 text-red-600 hover:bg-red-100 px-2.5 py-1.5 rounded-lg transition text-xs font-bold"
                                                        title="Tolak Absensi">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                        Tolak
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-[10px] text-red-400 italic font-medium">Driver upload ulang</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2 text-gray-400">
                                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            <p class="text-sm">Tidak ada data absensi</p>
                                            <p class="text-xs">Pilih tanggal lain untuk melihat data</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($attendances->hasPages())
                    <div class="px-5 py-3 border-t border-gray-100 bg-gray-50">
                        {{ $attendances->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Modal Edit Jam --}}
    <div id="modalEditJam" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeEditJam()"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm animate-rise">

                <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-4 rounded-t-2xl flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-white font-bold">Edit Jam Absensi</h3>
                    </div>
                    <button onclick="closeEditJam()" class="text-white/80 hover:text-white text-2xl font-bold leading-none">&times;</button>
                </div>

                <form id="formEditJam" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <div class="p-6 space-y-4">
                        <div class="bg-amber-50 rounded-xl p-3 text-amber-700 text-xs border border-amber-100">
                            Mengubah jam absensi yang tercatat di sistem. Tanggal tidak berubah.
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Jam Absen Baru</label>
                            <input type="time" name="jam_absen" id="inputJamAbsen" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-lg font-bold text-gray-700 focus:border-amber-400 focus:ring focus:ring-amber-100 transition bg-gray-50">
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 flex gap-3 justify-end rounded-b-2xl border-t border-gray-100">
                        <button type="button" onclick="closeEditJam()"
                            class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-600 font-medium hover:bg-gray-100 transition text-sm">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold transition text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Jam
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditJam(id, jamSekarang) {
            document.getElementById('inputJamAbsen').value = jamSekarang;
            let url = "{{ route('attendance.update', 'ID_PLACEHOLDER') }}";
            document.getElementById('formEditJam').action = url.replace('ID_PLACEHOLDER', id);
            document.getElementById('modalEditJam').classList.remove('hidden');
        }

        function closeEditJam() {
            document.getElementById('modalEditJam').classList.add('hidden');
        }

        document.onkeydown = function(e) {
            if (e.keyCode === 27) closeEditJam();
        };
    </script>
</x-app-layout>