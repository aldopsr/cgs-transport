<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 animate-rise">
            <svg class="w-6 h-6 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <h2 class="font-serif italic text-xl font-bold text-gray-800">Data Driver</h2>
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
                        <p class="font-bold text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Filter Section --}}
            <div class="bg-white rounded-2xl shadow-md border border-black/5 p-5 animate-rise">
                <form action="{{ route('drivers.index') }}" method="GET" class="flex flex-col md:flex-row items-center gap-3">
                    <div class="flex-1 w-full">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Cari nama atau plat nomor..." 
                                class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#1a6bff]/30 focus:border-[#1a6bff] bg-gray-50 transition">
                        </div>
                    </div>
                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" class="flex items-center justify-center gap-1.5 bg-[#1a6bff] hover:bg-[#0d5ae0] text-white font-semibold text-sm py-2.5 px-5 rounded-xl transition shadow-sm flex-1 md:flex-none">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('drivers.index') }}" class="flex items-center justify-center gap-1.5 bg-gray-500 hover:bg-gray-600 text-white font-semibold text-sm py-2.5 px-5 rounded-xl transition shadow-sm flex-1 md:flex-none">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Reset
                            </a>
                        @endif
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
                        Daftar Driver
                    </h3>
                    <span class="bg-blue-100 text-[#1a6bff] px-2.5 py-0.5 rounded-full font-bold text-[10px]">
                        {{ $drivers->count() }} driver
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-400 uppercase text-[9px] font-bold tracking-wider border-b border-gray-100">
                            <tr>
                                <th class="px-5 py-3">Driver</th>
                                <th class="px-5 py-3">No. Handphone</th>
                                <th class="px-5 py-3">Plat Nomor</th>
                                <th class="px-5 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 divide-y divide-gray-50">
                            @forelse($drivers as $driver)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center font-bold text-[#1a6bff] text-sm">
                                                {{ substr($driver->name, 0, 1) }}
                                            </div>
                                            <div class="font-semibold text-gray-800 text-sm">{{ $driver->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-sm text-gray-600">
                                        {{ $driver->phone }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[9px] font-bold rounded-full bg-yellow-50 text-yellow-700 border border-yellow-200 uppercase">
                                            <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                            {{ $driver->nopol }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="{{ route('drivers.edit', $driver->id) }}" 
                                               class="w-7 h-7 flex items-center justify-center bg-blue-50 text-[#1a6bff] hover:bg-[#1a6bff] hover:text-white rounded-lg transition">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            
                                            <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus driver ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-7 h-7 flex items-center justify-center bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2 text-gray-400">
                                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            <p class="text-sm">Tidak ada data driver</p>
                                            <p class="text-xs">Driver akan muncul setelah registrasi</p>
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
</x-app-layout>