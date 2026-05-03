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
            <span class="text-[10px] font-bold text-[#1a6bff] bg-[#e8f0ff] px-3 py-1 rounded-full uppercase">CGK</span>
        </div>

        <div class="h-[1px] bg-black/5 mb-8 animate-rise"></div>

        {{-- Hero --}}
        <div class="flex-1 flex flex-col justify-center py-4">
            <div class="flex items-center gap-2 text-[#1a6bff] text-[11px] font-bold uppercase tracking-[0.18em] mb-4 animate-rise">
                <div class="w-5 h-[1.5px] bg-[#1a6bff]"></div>
                Layanan Resmi Bandara
            </div>
            
            {{-- Ukuran dikecilkan ke text-4xl dan font-style tetap italic --}}
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
                    <a href="{{ route('login') }}" class="block">
                        <x-primary-button>
                            <span class="text-base">Masuk ke Akun</span>
                            <span class="bg-white/10 w-9 h-9 flex items-center justify-center rounded-full">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </span>
                        </x-primary-button>
                    </a>

                    @if (Route::has('register'))
                        <p class="text-center text-[12px] text-gray-400 font-medium py-1">Belum punya akun?</p>
                        <a href="{{ route('register') }}" class="block">
                            <x-secondary-button class="text-base py-5">Daftar sebagai Mitra</x-secondary-button>
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</x-guest-layout>