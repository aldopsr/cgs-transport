<x-app-layout>
    {{-- Hero Section --}}
    <div class="bg-gradient-to-r from-[#1a6bff] to-[#0d5ae0] pt-12 pb-16 rounded-b-[2.5rem] px-6 relative overflow-hidden shadow-lg shadow-blue-900/20 animate-rise">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-24 -mt-24"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-24 -mb-24"></div>
        
        <div class="relative z-10 text-center">
            <h2 class="text-white font-serif italic text-3xl">Profil Saya</h2>
            <p class="text-blue-100 text-[10px] mt-2 uppercase tracking-[0.2em] font-bold">Informasi Akun & Kendaraan</p>
        </div>
    </div>

    <div class="px-6 pb-20 relative z-20">
        
        {{-- Card Foto Profil --}}
        <div class="bg-white rounded-[2rem] shadow-xl text-center mb-6 border border-black/5 relative mt-16 animate-rise" style="animation-delay: 0.1s">
            {{-- Foto Profil --}}
            <div class="w-28 h-28 bg-white rounded-full flex items-center justify-center border-4 border-white shadow-xl absolute -top-14 left-1/2 transform -translate-x-1/2 overflow-hidden">
                @if($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-[#1a6bff] to-[#0d5ae0] flex items-center justify-center text-white font-bold text-3xl">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
            </div>
            
            <div class="pt-20 pb-6 px-5">
                <h3 class="font-serif italic text-2xl text-[#0d1117]">{{ $user->name }}</h3>
                <p class="text-gray-400 text-xs mt-1 font-medium">{{ $user->email }}</p>
                
                <div class="mt-4 inline-flex items-center gap-2 bg-blue-50 text-[#1a6bff] px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-widest border border-blue-100">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Mitra Driver
                </div>
            </div>
        </div>

        {{-- Informasi Detail --}}
        <div class="bg-white rounded-[1.5rem] shadow-lg overflow-hidden border border-black/5 divide-y divide-gray-100 animate-rise" style="animation-delay: 0.2s">
            {{-- Plat Nomor --}}
            <div class="px-5 py-4 flex items-center justify-between hover:bg-gray-50/50 transition">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-yellow-50 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Plat Nomor</span>
                </div>
                <span class="font-mono font-bold text-sm text-[#1a6bff] bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100 uppercase">{{ $user->nopol }}</span>
            </div>

            {{-- No HP --}}
            <div class="px-5 py-4 flex items-center justify-between hover:bg-gray-50/50 transition">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-50 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">No. Handphone</span>
                </div>
                <span class="font-bold text-sm text-gray-800">{{ $user->phone }}</span>
            </div>

            {{-- Status Akun --}}
            <div class="px-5 py-4 flex items-center justify-between hover:bg-gray-50/50 transition">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Status Akun</span>
                </div>
                <span class="inline-flex items-center gap-1.5 text-[9px] font-bold text-green-600 bg-green-50 px-3 py-1.5 rounded-full border border-green-100">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                    AKTIF
                </span>
            </div>

            {{-- Bergabung --}}
            <div class="px-5 py-4 flex items-center justify-between hover:bg-gray-50/50 transition">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-purple-50 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Bergabung Sejak</span>
                </div>
                <span class="text-xs text-gray-500 font-medium">{{ $user->created_at->translatedFormat('d F Y') }}</span>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-8 space-y-3 animate-rise" style="animation-delay: 0.3s">
            <a href="{{ route('dashboard') }}" class="flex items-center justify-center gap-2 w-full bg-[#1a6bff] text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-600/20 active:scale-95 transition hover:bg-[#0d5ae0] text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex items-center justify-center gap-2 w-full bg-red-50 text-red-600 font-bold py-4 rounded-xl border border-red-100 active:scale-95 transition hover:bg-red-100 text-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout (Keluar)
                </button>
            </form>
        </div>

        {{-- Footer Info --}}
        <div class="text-center mt-8 animate-rise" style="animation-delay: 0.4s">
            <p class="text-[9px] text-gray-400 leading-relaxed">
                Jika ada kesalahan data atau pergantian kendaraan,<br>hubungi Admin PT CSG Trans untuk perubahan.
            </p>
        </div>
    </div>
</x-app-layout>