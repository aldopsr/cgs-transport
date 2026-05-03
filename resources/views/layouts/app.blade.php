<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CSG System') }}</title>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1a6bff">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-white to-blue-50">
    
    <div class="min-h-screen">
        
        {{-- Navbar untuk Admin --}}
        @if(Auth::user()->role === 'admin')
        <nav class="bg-white/80 backdrop-blur-sm border-b border-blue-100 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-14">
                    <div class="flex items-center gap-6">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-7 h-7 object-contain">
                                <div>
                                    <span class="font-serif italic text-lg font-bold text-gray-800">CSG<span class="text-[#1a6bff]">Trans</span></span>
                                    <span class="text-[8px] font-bold text-blue-500 ml-0.5 hidden sm:inline">| OPS</span>
                                </div>
                            </div>
                        </a>

                        <div class="hidden sm:flex space-x-1">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                            <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')">Laporan</x-nav-link>
                            <x-nav-link :href="route('drivers.index')" :active="request()->routeIs('drivers.*')">Data Driver</x-nav-link>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2 bg-blue-50 px-3 py-1 rounded-full">
                            <div class="w-6 h-6 bg-gradient-to-br from-[#1a6bff] to-[#0d5ae0] rounded-full flex items-center justify-center text-white text-[10px] font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-xs font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-xs text-gray-400 hover:text-red-500 transition flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span class="hidden sm:inline">Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        @endif

        {{-- Navbar untuk Driver --}}
        @if(Auth::user()->role !== 'admin')
        <nav class="bg-white/80 backdrop-blur-sm border-b border-blue-100 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-14">
                    <div class="flex items-center gap-6">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-7 h-7 object-contain">
                                <div>
                                    <span class="font-serif italic text-lg font-bold text-gray-800">CSG<span class="text-[#1a6bff]">Trans</span></span>
                                    <span class="text-[8px] font-bold text-blue-500 ml-0.5 hidden sm:inline">| DRIVER</span>
                                </div>
                            </div>
                        </a>

                        <div class="hidden sm:flex space-x-1">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                            <x-nav-link :href="route('driver.ritase.index')" :active="request()->routeIs('driver.ritase*')">Riwayat</x-nav-link>
                            <x-nav-link :href="route('driver.profile')" :active="request()->routeIs('driver.profile*')">Profil</x-nav-link>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2 bg-blue-50 px-3 py-1 rounded-full">
                            <div class="w-6 h-6 bg-gradient-to-br from-[#1a6bff] to-[#0d5ae0] rounded-full flex items-center justify-center overflow-hidden">
                                @if(Auth::user()->photo)
                                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-white text-[10px] font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <span class="text-xs font-medium text-gray-700 hidden sm:block">{{ explode(' ', Auth::user()->name)[0] }}</span>
                            <span class="text-[9px] font-mono font-bold text-[#1a6bff] bg-white px-2 py-0.5 rounded-full hidden sm:block">{{ Auth::user()->nopol }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-xs text-gray-400 hover:text-red-500 transition flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span class="hidden sm:inline">Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        @endif

        {{-- Main Content --}}
        <main>
            {{ $slot }}
        </main>
    </div>

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js')
            .then(() => console.log('Service Worker Registered'));
        }
    </script>
</body>
</html>