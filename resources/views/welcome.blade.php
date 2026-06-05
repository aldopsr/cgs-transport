<x-guest-layout>
    {{-- Background --}}
    <div class="fixed inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1530521954074-e64f6810b32d?q=80&w=2070&auto=format&fit=crop"
             class="w-full h-full object-cover opacity-10 mix-blend-luminosity">
        <div class="absolute inset-0 bg-gradient-to-tr from-[#eef2ff] via-[#f4f6f9] to-[#e8f0ff] opacity-95"></div>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col max-w-screen-xl mx-auto px-6 md:px-12 lg:px-20">

        {{-- Hero --}}
        <div class="flex-1 flex flex-col items-center justify-center gap-6 py-4">

            {{-- Logo & Welcome --}}
            <div class="flex flex-col items-center gap-2 text-center">
                <img src="{{ asset('logo.png') }}" alt="Logo PT CSG" class="w-20 h-20 object-contain mb-1">
                <span class="font-serif italic text-2xl font-bold text-gray-800">CSG<span class="text-[#1a6bff]">Trans</span></span>
                <span class="text-[10px] font-bold text-blue-400 tracking-widest uppercase">Operations</span>
                <p class="font-serif italic text-gray-400 text-sm mt-1">Selamat datang — silakan masuk untuk melanjutkan.</p>
            </div>

            {{-- CTA --}}
            <div class="space-y-3 w-full max-w-xs">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block">
                            <x-primary-button class="w-full py-4 justify-between">
                                <span>{{ Auth::user()->name }}</span>
                                <span class="bg-white/10 w-8 h-8 flex items-center justify-center rounded-full">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </span>
                            </x-primary-button>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block">
                            <button class="w-full bg-gradient-to-r from-[#1a6bff] to-[#0d5ae0] text-white font-bold py-4 rounded-2xl flex items-center justify-between px-6 transition-all hover:scale-[1.02] active:scale-95">
                                <span>Masuk ke Akun</span>
                                <span class="bg-white/20 w-8 h-8 flex items-center justify-center rounded-full">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </span>
                            </button>
                        </a>

                        @if (Route::has('register'))
                            <div class="relative py-1">
                                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-black/5"></div></div>
                                <div class="relative flex justify-center text-[11px] uppercase font-bold tracking-widest">
                                    <span class="bg-[#f4f6f9] px-4 text-gray-400">Atau</span>
                                </div>
                            </div>

                            <a href="{{ route('register') }}" class="block">
                                <button class="w-full bg-white/80 backdrop-blur border-2 border-[#1a6bff] text-[#1a6bff] font-bold py-4 rounded-2xl flex items-center justify-between px-6 transition-all hover:scale-[1.01] active:scale-95">
                                    <span>Daftar sebagai Mitra</span>
                                    <span class="bg-[#1a6bff]/10 w-8 h-8 flex items-center justify-center rounded-full">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1a6bff" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                    </span>
                                </button>
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

        </div>

        {{-- Footer --}}
        <footer class="py-8 border-t border-black/5">
            <p class="text-[10px] text-gray-400 uppercase tracking-[0.3em]">&copy; {{ date('Y') }} PT CSG Transportasi. All Rights Reserved.</p>
        </footer>

    </div>
</x-guest-layout>