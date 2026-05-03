<x-guest-layout>
    {{-- Background Layer tetap sama --}}
    <div class="fixed inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1530521954074-e64f6810b32d?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover opacity-10 mix-blend-luminosity">
        <div class="absolute inset-0 bg-gradient-to-tr from-[#eef2ff] via-[#f4f6f9] to-[#e8f0ff] opacity-90"></div>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col px-6">
        {{-- Top Bar --}}
        <div class="flex items-center justify-between py-8 animate-rise">
            <x-application-logo />
        </div>

        <div class="h-[1px] bg-black/5 mb-8 animate-rise"></div>

        {{-- Hero --}}
        <div class="flex-1 flex flex-col justify-center py-4">
            <div class="flex items-center gap-2 text-[#1a6bff] text-[11px] font-bold uppercase tracking-[0.18em] mb-4 animate-rise">
                <div class="w-5 h-[1.5px] bg-[#1a6bff]"></div>
                Layanan Resmi Bandara
            </div>
            
            <h1 class="text-4xl font-serif italic leading-[1.2] text-[#0d1117] mb-6 animate-rise">
                Tepat Waktu,<br>Setiap <span class="text-[#1a6bff]">Saat.</span>
            </h1>
            
            <p class="text-[14px] text-gray-500 leading-relaxed max-w-[280px] font-light animate-rise">
                Sistem operasional penjemputan dan pengantaran Soekarno-Hatta International Airport.
            </p>
        </div>

        {{-- CTA Area --}}
        <div class="pb-10 space-y-3 animate-rise">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="block">
                        <x-primary-button>
                            <div class="flex flex-col text-left leading-tight">
                                <span class="text-[10px] font-normal opacity-70 uppercase tracking-wider">Buka Aplikasi</span>
                                <span class="text-base">{{ Auth::user()->name }}</span>
                            </div>
                            <span class="bg-white/10 w-8 h-8 flex items-center justify-center rounded-full">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </span>
                        </x-primary-button>
                    </a>
                @else
                    {{-- Tombol Login dengan gradasi halus --}}
                    <a href="{{ route('login') }}" class="block">
                        <button class="w-full bg-gradient-to-r from-[#1a6bff] to-[#0d5ae0] hover:from-[#0d5ae0] hover:to-[#1a6bff] text-white font-bold py-5 rounded-2xl shadow-lg shadow-blue-600/20 transform transition-all duration-300 hover:scale-[1.02] active:scale-95 flex items-center justify-between px-6 group">
                            <span class="text-base tracking-wide">Masuk ke Akun</span>
                            <span class="bg-white/20 group-hover:bg-white/30 w-9 h-9 flex items-center justify-center rounded-full transition-all duration-300">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </button>
                    </a>

                    @if (Route::has('register'))
                        <p class="text-center text-[12px] text-gray-400 font-medium py-2">Belum punya akun?</p>
                        
                        {{-- Tombol Daftar Mitra dengan border biru dan teks biru --}}
                        <a href="{{ route('register') }}" class="block">
                            <button class="w-full bg-white/80 backdrop-blur-sm border-2 border-[#1a6bff] hover:border-[#0d5ae0] text-[#1a6bff] hover:text-[#0d5ae0] font-bold py-5 rounded-2xl shadow-md hover:shadow-lg transform transition-all duration-300 hover:scale-[1.01] active:scale-95 flex items-center justify-between px-6 group">
                                <span class="text-base tracking-wide">Daftar sebagai Mitra</span>
                                <span class="bg-[#1a6bff]/10 group-hover:bg-[#1a6bff]/20 w-9 h-9 flex items-center justify-center rounded-full transition-all duration-300">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <path d="M5 12h14M12 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </button>
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</x-guest-layout>