<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PT CSG - Airport Transport</title>

        <linkpreconnect="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-slate-900 text-white font-sans selection:bg-sky-500 selection:text-white">
        
        <div class="fixed inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1530521954074-e64f6810b32d?q=80&w=2070&auto=format&fit=crop" 
                 alt="Airport Background" 
                 class="w-full h-full object-cover opacity-40">
            
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/90 via-slate-900/60 to-slate-900"></div>
        </div>

        <div class="relative z-10 min-h-screen flex flex-col justify-between px-6 py-8">
            
            <div class="text-center pt-8 animate-fade-in-down">
                <div class="relative inline-block mb-4">
                    <div class="absolute inset-0 bg-sky-500 blur-xl opacity-30 rounded-full"></div>
                    <div class="relative inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-sky-500 to-blue-700 rounded-2xl shadow-2xl border border-white/10">
                        <span class="text-4xl drop-shadow-md">✈️</span>
                    </div>
                </div>
                
                <h1 class="text-3xl font-black tracking-tight text-white mb-1">
                    PT CSG
                    <span class="text-sky-400">TRANS</span>
                </h1>
                <p class="text-sky-200 text-xs font-bold tracking-[0.2em] uppercase">Soekarno-Hatta Airport Service</p>
            </div>

            <div class="text-center space-y-3">
                <h2 class="text-2xl font-bold leading-tight">
                    Mitra Perjalanan <br>
                    <span class="text-sky-400">Terpercaya.</span>
                </h2>
                <p class="text-sm text-slate-400 max-w-xs mx-auto leading-relaxed">
                    Sistem operasional resmi penjemputan & pengantaran bandara.
                </p>
            </div>

            <div class="w-full max-w-md mx-auto space-y-4 pb-4 animate-fade-in-up">
                
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" 
                           class="group flex items-center justify-between w-full bg-gradient-to-r from-sky-600 to-blue-700 hover:from-sky-500 hover:to-blue-600 text-white font-bold py-4 px-6 rounded-2xl shadow-lg transition transform active:scale-95 border border-white/10">
                            <span class="flex flex-col text-left">
                                <span class="text-xs text-sky-200 font-normal">Halo, {{ Auth::user()->name }}</span>
                                <span class="text-lg">Buka Aplikasi</span>
                            </span>
                            <span class="text-2xl">👉</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="flex items-center justify-center w-full bg-white text-slate-900 font-black text-lg py-4 px-6 rounded-2xl shadow-xl transition transform active:scale-95 hover:bg-sky-50">
                            <span class="mr-3 text-2xl">🚖</span>
                            <span>LOGIN</span>
                        </a>

                        @if (Route::has('register'))
                            <div class="text-center mt-4 mb-2">
                                <p class="text-xs text-slate-500 uppercase tracking-wider">Belum punya akun?</p>
                            </div>

                            <a href="{{ route('register') }}" 
                               class="flex items-center justify-center w-full bg-slate-800/50 backdrop-blur-md border border-slate-600 hover:border-sky-500 text-slate-300 hover:text-white font-bold py-4 px-6 rounded-2xl transition transform active:scale-95">
                                <span>Daftar Mitra Baru</span>
                            </a>
                        @endif
                    @endauth
                @endif

                <div class="text-center pt-8 opacity-60">
                    <p class="text-[10px] text-slate-500">
                        &copy; {{ date('Y') }} PT CSG Transportasi.<br>Soekarno-Hatta International Airport.
                    </p>
                </div>
            </div>
        </div>

        <style>
            @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
            @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
            .animate-fade-in-down { animation: fadeInDown 1s cubic-bezier(0.2, 0.8, 0.2, 1); }
            .animate-fade-in-up { animation: fadeInUp 1s cubic-bezier(0.2, 0.8, 0.2, 1); }
        </style>
    </body>
</html>