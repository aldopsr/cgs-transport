<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 animate-rise">
            <svg class="w-6 h-6 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M6 19h12M6 4h12M4 7h16M4 13h16M4 17h16" />
                <rect x="7" y="4" width="10" height="16" rx="2" stroke="currentColor" stroke-width="2" />
            </svg>
            <h2 class="font-serif italic text-xl font-bold text-gray-800">Riwayat Absensi</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Filter Section --}}
            <div class="bg-white rounded-2xl shadow-md border border-black/5 p-5 animate-rise">
                <form action="{{ route('admin.attendance.index') }}" method="GET" class="flex flex-col md:flex-row items-end justify-between gap-4">
                    <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                        <div>
                            <label class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-1.5 ml-1">Filter Tanggal</label>
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <input type="date" name="date" value="{{ request('date') }}" 
                                    class="pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#1a6bff]/30 focus:border-[#1a6bff] bg-gray-50 transition w-full md:w-56">
                            </div>
                        </div>
                        <div class="flex gap-2 items-end">
                            <button type="submit" class="flex items-center gap-1.5 bg-[#1a6bff] hover:bg-[#0d5ae0] text-white font-bold text-xs py-2.5 px-5 rounded-xl transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Tampilkan
                            </button>
                            @if(request('date'))
                                <a href="{{ route('admin.attendance.index') }}" class="flex items-center gap-1.5 bg-gray-500 hover:bg-gray-600 text-white font-bold text-xs py-2.5 px-5 rounded-xl transition shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Reset
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="bg-blue-100 text-[#1a6bff] px-3 py-1.5 rounded-full font-bold text-[10px]">
                            Total: {{ $attendances->total() }} absensi
                        </span>
                    </div>
                </form>
            </div>

            {{-- Table Section --}}
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
                                <th class="px-5 py-3">Tanggal Absensi</th>
                                <th class="px-5 py-3">Nama Driver</th>
                                <th class="px-5 py-3">Plat Nomor</th>
                                <th class="px-5 py-3">Waktu Absen</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3 text-center">Bukti Foto</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 divide-y divide-gray-50">
                            @forelse($attendances as $absen)
                            <tr class="hover:bg-gray-50/50 transition">
                                {{-- Tanggal Absensi --}}
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center">
                                            <svg class="w-3.5 h-3.5 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-800 text-sm">{{ \Carbon\Carbon::parse($absen->date)->isoFormat('D MMMM Y') }}</div>
                                            <div class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($absen->date)->translatedFormat('l') }}</div>
                                        </div>
                                    </div>
                                
    
                                {{-- Nama Driver --}}
                                <td class="px-5 py-3.5">
                                    <div class="font-semibold text-gray-800 text-sm">{{ $absen->user->name ?? 'Driver Tidak Ditemukan' }}</div>
                                    <div class="text-[10px] text-gray-400">{{ $absen->user->email ?? '-' }}</div>
                                
    
                                {{-- Plat Nomor --}}
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[9px] font-bold rounded-full bg-yellow-50 text-yellow-700 border border-yellow-200 uppercase">
                                        <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        {{ $absen->user->nopol ?? '-' }}
                                    </span>
                                
    
                                {{-- Waktu Absen --}}
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-sm text-gray-600">{{ $absen->created_at->format('H:i') }} WIB</span>
                                    </div>
                                
    
                                {{-- Status --}}
                                <td class="px-5 py-3.5">
                                    @if($absen->status == 'verified')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-700">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Terverifikasi
                                        </span>
                                    @elseif($absen->status == 'rejected')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-700">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-700">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <circle cx="12" cy="12" r="10"/>
                                                <polyline points="12 6 12 12 16 14"/>
                                            </svg>
                                            Pending
                                        </span>
                                    @endif
                                
    
                                {{-- Bukti Foto --}}
                                <td class="px-5 py-3.5 text-center">
                                    @if($absen->payment_proof)
                                        <a href="{{ asset('storage/' . $absen->payment_proof) }}" target="_blank" 
                                            class="inline-flex items-center gap-1.5 bg-blue-50 text-[#1a6bff] hover:bg-[#1a6bff] hover:text-white px-3 py-1.5 rounded-lg transition text-xs font-bold">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Lihat Foto
                                        </a>
                                    @else
                                        <span class="text-[10px] text-gray-400 italic">-</span>
                                    @endif
                                
    
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2 text-gray-400">
                                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <p class="text-sm">Tidak ada data absensi</p>
                                        <p class="text-xs">Pilih tanggal lain untuk melihat data</p>
                                    </div>
                                
    
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                @if($attendances->hasPages())
                    <div class="px-5 py-3 border-t border-gray-100 bg-gray-50">
                        {{ $attendances->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>