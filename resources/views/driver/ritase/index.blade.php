<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-[#1a6bff] transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <h2 class="font-serif italic text-xl font-bold text-gray-800">Riwayat Ritase</h2>
        </div>
    </x-slot>

    <div class="py-6 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
            
            {{-- Filter --}}
            <div class="bg-white rounded-2xl shadow-md border border-black/5 p-5 animate-rise">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-4 h-4 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <p class="text-[10px] font-bold text-[#1a6bff] uppercase tracking-wider">Cari Riwayat</p>
                </div>
                
                <form action="{{ route('driver.ritase.index') }}" method="GET" class="space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-[9px] text-gray-400 font-bold uppercase tracking-wider block mb-1">Dari</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" 
                                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:ring-[#1a6bff] focus:border-[#1a6bff] bg-gray-50">
                        </div>
                        <div>
                            <label class="text-[9px] text-gray-400 font-bold uppercase tracking-wider block mb-1">Sampai</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" 
                                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:ring-[#1a6bff] focus:border-[#1a6bff] bg-gray-50">
                        </div>
                    </div>
                    
                    <div class="flex gap-2 pt-2">
                        <button type="submit" class="flex-1 bg-[#1a6bff] text-white text-sm font-bold py-3 rounded-xl shadow-md active:scale-95 transition hover:bg-[#0d5ae0]">
                            Tampilkan Data
                        </button>
                        @if(request('start_date') || request('end_date'))
                            <a href="{{ route('driver.ritase.index') }}" class="px-5 py-3 bg-gray-100 text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-200 transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- List Riwayat --}}
            <div class="space-y-3">
                @forelse($ritases as $ritase)
                    <div class="bg-white rounded-2xl p-5 shadow-md border border-black/5 relative overflow-hidden animate-rise transition hover:shadow-lg">
                        {{-- Garis Pinggir --}}
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-{{ $ritase->pendapatan > 0 ? 'green' : 'gray' }}-500 rounded-l-2xl"></div>

                        <div class="pl-3">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-[10px] font-bold text-gray-500">
                                            {{ $ritase->created_at->format('d M Y') }}
                                        </span>
                                        <span class="text-[9px] text-gray-400">•</span>
                                        <span class="text-[10px] font-medium text-gray-400">
                                            {{ $ritase->created_at->format('H:i') }}
                                        </span>
                                    </div>
                                    
                                    <h3 class="font-bold text-gray-800 text-base">
                                        {{ $ritase->tujuan ?? 'Ritase Reguler' }}
                                    </h3>
                                    
                                    <div class="flex items-center gap-2 mt-2">
                                        <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <p class="text-xs text-gray-500">
                                            Penumpang: <span class="font-semibold text-gray-700">{{ $ritase->nama_penumpang ?? '-' }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="text-right ml-4">
                                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mb-1">Pendapatan</p>
                                    <p class="text-lg font-black text-green-600">
                                        Rp {{ number_format($ritase->pendapatan, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl py-12 text-center border border-black/5 animate-rise">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <p class="text-gray-600 font-bold text-sm">Belum ada riwayat perjalanan</p>
                        <p class="text-xs text-gray-400 mt-1">Data ritase akan muncul setelah Anda menyelesaikan perjalanan</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="pt-4 pb-8">
                {{ $ritases->withQueryString()->links() }}
            </div>

        </div>
    </div>
</x-app-layout>