<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-indigo-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            📄 Riwayat Ritase
        </h2>
    </x-slot>

    <div class="py-6 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-xs font-bold text-indigo-600 mb-2 uppercase tracking-wide">🔍 Cari Riwayat</p>
                <form action="{{ route('driver.ritase.index') }}" method="GET" class="space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-[10px] text-gray-400 font-bold">Dari</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" 
                                class="w-full text-sm border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50">
                        </div>
                        <div>
                            <label class="text-[10px] text-gray-400 font-bold">Sampai</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" 
                                class="w-full text-sm border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50">
                        </div>
                    </div>
                    
                    <div class="flex gap-2 pt-1">
                        <button type="submit" class="flex-1 bg-indigo-600 text-white text-sm font-bold py-2.5 rounded-xl shadow-md active:scale-95 transition hover:bg-indigo-700">
                            Tampilkan Data
                        </button>
                        @if(request('start_date'))
                            <a href="{{ route('driver.ritase.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-200 transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="space-y-3">
                @forelse($ritases as $ritase)
                    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 relative overflow-hidden">
                        {{-- Hiasan Garis Pinggir --}}
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-{{ $ritase->pendapatan > 0 ? 'green' : 'gray' }}-500"></div>

                        <div class="pl-3 flex justify-between items-start">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-[10px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">
                                        {{ $ritase->created_at->format('d M Y') }}
                                    </span>
                                    <span class="text-[10px] font-bold text-gray-400">
                                        {{ $ritase->created_at->format('H:i') }}
                                    </span>
                                </div>
                                
                                <h3 class="font-bold text-gray-800 text-base">
                                    {{ $ritase->tujuan ?? 'Ritase Reguler' }}
                                </h3>
                                
                                <p class="text-xs text-gray-500 mt-0.5">
                                    Penumpang: <span class="font-semibold text-gray-700">{{ $ritase->nama_penumpang ?? '-' }}</span>
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-[10px] text-gray-400 font-bold uppercase">Pendapatan</p>
                                <p class="text-lg font-black text-green-600">
                                    <span class="text-xs align-top">Rp</span>{{ number_format($ritase->pendapatan, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center">
                        <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-3xl grayscale">📭</span>
                        </div>
                        <p class="text-gray-500 font-bold text-sm">Belum ada riwayat perjalanan.</p>
                        <p class="text-xs text-gray-400 mt-1">Data ritase akan muncul setelah Anda menyelesaikan perjalanan.</p>
                    </div>
                @endforelse
            </div>

            <div class="pt-4 pb-8">
                {{ $ritases->withQueryString()->links() }}
            </div>

        </div>
    </div>
</x-app-layout>