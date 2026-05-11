<x-guest-layout>
    {{-- Background Layer --}}
    <div class="fixed inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1530521954074-e64f6810b32d?q=80&w=2070&auto=format&fit=crop" 
             class="w-full h-full object-cover opacity-10 mix-blend-luminosity">
        <div class="absolute inset-0 bg-gradient-to-tr from-[#eef2ff] via-[#f4f6f9] to-[#e8f0ff] opacity-95"></div>
    </div>

    {{-- Container Utama: Membatasi lebar di layar besar (max-w-screen-xl) --}}
    <div class="relative z-10 min-h-screen flex flex-col max-w-screen-xl mx-auto px-6 md:px-12 lg:px-20">
        
        {{-- Top Bar --}}
        <div class="flex items-center justify-between py-8 animate-rise">
            <x-application-logo />
            {{-- Tambahan Badge Lokasi untuk Desktop --}}
            <div class="hidden md:flex items-center gap-2 bg-white/50 backdrop-blur px-4 py-2 rounded-full border border-black/5 shadow-sm">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Operational: CGK Terminal 3</span>
            </div>
        </div>

        <div class="h-[1px] bg-black/5 mb-8 md:mb-12 animate-rise"></div>

        {{-- Hero Section: Grid 2 kolom di layar besar --}}
        <div class="flex-1 lg:grid lg:grid-cols-2 lg:items-center gap-12 py-4">
            
            <div class="space-y-6">
                <div class="flex items-center gap-2 text-[#1a6bff] text-[11px] md:text-[13px] font-bold uppercase tracking-[0.18em] mb-4 animate-rise">
                    <div class="w-5 h-[1.5px] bg-[#1a6bff]"></div>
                    Layanan Resmi Bandara
                </div>
                
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-serif italic leading-[1.1] text-[#0d1117] animate-rise">
                    Tepat Waktu,<br>Setiap <span class="text-[#1a6bff]">Saat.</span>
                </h1>
                
                <p class="text-[14px] md:text-[16px] text-gray-500 leading-relaxed max-w-[280px] md:max-w-md font-light animate-rise">
                    Sistem operasional penjemputan dan pengantaran Soekarno-Hatta International Airport. Nikmati layanan transportasi kelas satu untuk kebutuhan perjalanan Anda.
                </p>
            </div>

            {{-- CTA Area: Dibungkus container agar tidak selebar layar di Desktop --}}
            <div class="mt-10 lg:mt-0 pb-10 space-y-4 animate-rise max-w-md lg:ml-auto w-full">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block">
                            <x-primary-button class="w-full py-6">
                                <div class="flex flex-col text-left leading-tight">
                                    <span class="text-[10px] font-normal opacity-70 uppercase tracking-wider">Buka Aplikasi</span>
                                    <span class="text-lg">{{ Auth::user()->name }}</span>
                                </div>
                                <span class="bg-white/10 w-10 h-10 flex items-center justify-center rounded-full">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </span>
                            </x-primary-button>
                        </a>
                    @else
                        {{-- Tombol Login --}}
                        <a href="{{ route('login') }}" class="block">
                            <button class="w-full bg-gradient-to-r from-[#1a6bff] to-[#0d5ae0] hover:from-[#0d5ae0] hover:to-[#1a6bff] text-white font-bold py-6 rounded-2xl shadow-xl shadow-blue-600/20 transform transition-all duration-300 hover:scale-[1.02] active:scale-95 flex items-center justify-between px-8 group">
                                <span class="text-lg tracking-wide">Masuk ke Akun</span>
                                <span class="bg-white/20 group-hover:bg-white/30 w-10 h-10 flex items-center justify-center rounded-full transition-all duration-300">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <path d="M5 12h14M12 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </button>
                        </a>

                        @if (Route::has('register'))
                            <div class="relative py-2">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-black/5"></div>
                                </div>
                                <div class="relative flex justify-center text-[12px] uppercase font-bold tracking-widest">
                                    <span class="bg-[#f4f6f9] px-4 text-gray-400">Atau</span>
                                </div>
                            </div>
                            
                            {{-- Tombol Daftar Mitra --}}
                            <a href="{{ route('register') }}" class="block">
                                <button class="w-full bg-white/80 backdrop-blur-sm border-2 border-[#1a6bff] hover:border-[#0d5ae0] text-[#1a6bff] hover:text-[#0d5ae0] font-bold py-6 rounded-2xl shadow-md hover:shadow-lg transform transition-all duration-300 hover:scale-[1.01] active:scale-95 flex items-center justify-between px-8 group">
                                    <span class="text-lg tracking-wide">Daftar sebagai Mitra</span>
                                    <span class="bg-[#1a6bff]/10 group-hover:bg-[#1a6bff]/20 w-10 h-10 flex items-center justify-center rounded-full transition-all duration-300">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
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

        {{-- Footer Sederhana --}}
        <footer class="py-8 text-center lg:text-left animate-rise">
            <p class="text-[10px] text-gray-400 uppercase tracking-[0.3em]">&copy; {{ date('Y') }} PT CSG Transportasi. All Rights Reserved.</p>
        </footer>
    </div>
</x-guest-layout>