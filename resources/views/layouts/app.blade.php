<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"> <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CSG System') }}</title>
    <link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#0d6efd">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Sembunyikan Scrollbar biar rapi */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-slate-800">
    
    <div class="flex h-screen overflow-hidden">
        
        @if(Auth::user()->role === 'admin') 
        <aside class="w-64 bg-[#0f172a] text-white flex flex-col shadow-2xl z-50 hidden md:flex">
            <div class="p-6">
                <h1 class="text-2xl font-black tracking-tighter text-blue-500">
                    CSG <span class="text-white">AIRPORT</span>
                </h1>
                <p class="text-xs text-slate-500 font-medium tracking-widest mt-1">OPERATING SYSTEM</p>
            </div>

            <nav class="flex-1 px-4 space-y-2 mt-4">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800' }}">
                    <span class="font-bold text-sm">Dashboard</span>
                </a>

                @if(Route::has('drivers.index'))
                <a href="{{ route('drivers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('drivers.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800' }}">
                    <span class="font-medium text-sm">Data Driver</span>
                </a>
                @endif

                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('reports.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800' }}">
                    <span class="font-medium text-sm">Laporan</span>
                </a>

                <a href="{{ route('admin.attendance.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.attendance.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800' }}">
                    <span class="font-medium text-sm">Absensi</span>
                </a>

                <!-- <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('profile.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800' }}">
                    <span class="font-medium text-sm">Pengaturan</span>
                </a> -->
            </nav>

            <div class="p-4 border-t border-slate-800 mt-auto">
                 <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-xs text-center text-slate-500 hover:text-red-400 transition">Log Out</button>
                </form>
            </div>
        </aside>
        @endif

        <div class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#F3F4F6] relative">
            
            @if(Auth::user()->role !== 'admin')
            <div class="bg-blue-600 text-white p-4 flex justify-between items-center shadow-lg sticky top-0 z-50">
                <div class="flex items-center gap-3">
                     <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                     </div>
                     <div class="fixed top-0 inset-x-0 z-50 bg-[#0f172a] px-5 py-3 shadow-xl border-b border-slate-800 flex justify-between items-center">
        <div>
            <p class="text-blue-500 text-[10px] font-bold tracking-[0.2em] uppercase leading-tight">PT. CSG</p>
            <h1 class="text-white text-lg font-black tracking-tighter leading-none mt-0.5">OPERATIONS</h1>
        </div>
    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-blue-700 p-2 rounded-lg text-white hover:bg-red-500 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
            @endif

            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>
    <script>
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js')
    .then(() => console.log('Service Worker Registered'));
}
</script>
</body>
</html>