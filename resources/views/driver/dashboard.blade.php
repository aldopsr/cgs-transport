<x-app-layout>
    @php
        $today = date('Y-m-d');
        $user_id = Auth::id();
        
        // Cek Absensi
        $attendance = App\Models\Attendance::where('user_id', $user_id)->where('date', $today)->first();
        
        // Cek Antrian Aktif
        $activeQueue = App\Models\Queue::where('user_id', $user_id)
                        ->whereDate('created_at', $today)
                        ->whereIn('status', ['menunggu', 'dipanggil'])
                        ->first();

        // Ambil Data Ritase Hari Ini (Jumlah & Total Duit)
        $ritaseQuery = App\Models\Ritase::where('user_id', $user_id)->whereDate('created_at', $today);
        $ritaseCount = $ritaseQuery->count();
        $revenueToday = $ritaseQuery->sum('pendapatan');
    @endphp

    {{-- HEADER BIRU --}}
    <div class="bg-indigo-600 pt-8 pb-20 rounded-b-[3rem] px-6 shadow-xl relative overflow-hidden">
        {{-- Hiasan Background --}}
        <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-32 h-32 bg-indigo-500/30 rounded-full blur-xl"></div>

        <div class="relative z-10 flex justify-between items-start">
            <div class="text-white">
                <p class="text-indigo-200 text-sm font-medium">Halo, Driver</p>
                <h1 class="text-3xl font-black leading-tight tracking-tight">{{ explode(' ', Auth::user()->name)[0] }}</h1>
                <div class="mt-2 inline-flex items-center gap-2 bg-indigo-700/50 backdrop-blur-md rounded-full px-3 py-1 border border-indigo-500/30">
                    <span class="text-[10px] uppercase font-bold text-indigo-200">Plat Nomor</span>
                    <span class="text-xs font-mono font-bold text-white tracking-wider">{{ Auth::user()->nopol }}</span>
                </div>
            </div>
            
            <a href="{{ route('driver.profile') }}" class="bg-white/10 p-1.5 rounded-full backdrop-blur-sm border border-white/20 active:bg-white/20 transition shadow-lg">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-indigo-600 font-bold shadow-inner text-lg">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </a>
        </div>
    </div>

    <div class="px-5 -mt-14 pb-24 relative z-20 space-y-6">

        {{-- CARD STATISTIK (Trip, Duit, Status) --}}
        <div class="bg-white rounded-3xl shadow-lg p-5 grid grid-cols-3 divide-x divide-gray-100 items-center">
            
            {{-- Kolom 1: Trip --}}
            <div class="text-center px-1">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Total Trip</p>
                <p class="text-2xl font-black text-gray-800">{{ $ritaseCount }}</p>
            </div>

            {{-- Kolom 2: Pendapatan --}}
            <div class="text-center px-1">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Omzet</p>
                <p class="text-lg font-black text-green-600 truncate">
                    <span class="text-[10px] align-top text-green-500">Rp</span>{{ number_format($revenueToday / 1000, 0) }}k
                </p>
            </div>

            {{-- Kolom 3: Status --}}
            <div class="text-center px-1 flex flex-col items-center justify-center h-full">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Status</p>
                @if(!$attendance) 
                    <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded-md text-[10px] font-bold border border-gray-200">Off</span>
                @elseif($attendance->status == 'pending') 
                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-md text-[10px] font-bold border border-yellow-200">Cek</span>
                @elseif($attendance->status == 'verified') 
                    <span class="bg-green-100 text-green-600 px-2 py-1 rounded-md text-[10px] font-bold border border-green-200">Aktif</span>
                @else 
                    <span class="bg-red-100 text-red-600 px-2 py-1 rounded-md text-[10px] font-bold border border-red-200">Tolak</span>
                @endif
            </div>
        </div>

        {{-- LOGIC FLOW UTAMA --}}
        @if(!$attendance || $attendance->status != 'verified')
            
            {{-- CASE 1: BELUM ABSEN --}}
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-100">
                @if(!$attendance || $attendance->status == 'rejected')
                    <div class="bg-gray-50 p-4 border-b border-gray-100 text-center">
                        <p class="text-gray-600 font-bold text-sm">⛔ Operasional Belum Dimulai</p>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('attendance.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="group block w-full h-36 border-2 border-dashed border-gray-300 hover:border-indigo-400 rounded-2xl flex flex-col items-center justify-center bg-gray-50 mb-4 cursor-pointer transition-all">
                                <div class="bg-white p-3 rounded-full shadow-sm mb-2 group-hover:scale-110 transition">
                                    <span class="text-2xl">📸</span>
                                </div>
                                <span class="text-xs text-gray-500 font-bold group-hover:text-indigo-500">Upload Bukti Transfer</span>
                                <input type="file" name="payment_proof" required class="hidden" onchange="this.parentElement.classList.add('border-green-500', 'bg-green-50'); this.parentElement.querySelector('span.text-xs').innerText='✅ Foto Siap Dikirim!';">
                            </label>
                            <button class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl shadow-lg active:scale-95 transition hover:bg-indigo-700 flex items-center justify-center gap-2">
                                🚀 MULAI KERJA
                            </button>
                        </form>
                    </div>
                @else
                    {{-- CASE 2: MENUNGGU VERIFIKASI ABSEN --}}
                    <div class="p-8 text-center">
                        <div class="inline-block p-4 rounded-full bg-yellow-50 mb-3 animate-pulse">
                            <span class="text-4xl">⏳</span>
                        </div>
                        <h3 class="font-bold text-gray-800 text-lg">Menunggu Admin</h3>
                        <p class="text-sm text-gray-500 mt-1">Data absensi sedang diperiksa...</p>
                        <button onclick="window.location.reload()" class="mt-6 text-indigo-600 text-xs font-bold hover:underline">🔄 Cek Status</button>
                    </div>
                @endif
            </div>

        @else

            {{-- CASE 3: SUDAH KERJA (ABSEN OK) --}}
            
            {{-- BAGIAN ANTRIAN --}}
            @if($activeQueue)
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden text-center relative border border-gray-100">
                    <div class="{{ $activeQueue->status == 'dipanggil' ? 'bg-green-500' : 'bg-indigo-600' }} py-3 px-4 flex justify-between items-center">
                        <p class="text-white text-[10px] font-bold uppercase tracking-widest opacity-90">Nomor Antrian</p>
                        @if($activeQueue->status == 'menunggu')
                            <span class="bg-white/20 text-white text-[10px] px-2 py-0.5 rounded-full">Menunggu</span>
                        @endif
                    </div>
                    
                    <div class="py-10 relative">
                        {{-- Watermark Background --}}
                        <span class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-9xl text-gray-50 font-black select-none pointer-events-none z-0">
                            {{ $activeQueue->queue_number }}
                        </span>
                        <span class="relative z-10 text-8xl font-black text-gray-800 tracking-tighter drop-shadow-sm">
                            {{ $activeQueue->queue_number }}
                        </span>
                    </div>

                    <div class="px-5 pb-6">
                        @if($activeQueue->status == 'dipanggil')
                            {{-- MODAL ACTIVE: DIPANGGIL --}}
                            <div class="bg-green-50 text-green-800 p-5 rounded-2xl border border-green-200 shadow-inner">
                                <div class="animate-bounce mb-4 text-center">
                                    <p class="font-black text-xl">📢 SEGERA MASUK!</p>
                                    <p class="text-xs opacity-80">Giliran Anda muat penumpang.</p>
                                </div>

                                <a href="{{ route('driver.ritase.create') }}" class="group block w-full bg-gradient-to-r from-green-500 to-green-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-green-200 hover:shadow-green-300 transition-all active:scale-95 flex items-center justify-center gap-3">
                                    <span class="bg-white/20 p-1 rounded text-lg">📸</span> 
                                    <div class="text-left leading-tight">
                                        <span class="block text-xs font-medium text-green-100">Sudah Selesai?</span>
                                        <span class="block text-sm">UPLOAD BUKTI / SCAN</span>
                                    </div>
                                    <span class="text-green-100 group-hover:translate-x-1 transition">→</span>
                                </a>
                            </div>
                        @else
                            {{-- MENUNGGU --}}
                            <div class="bg-gray-50 text-gray-500 p-4 rounded-xl border border-gray-200 flex items-center justify-center gap-3">
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-ping"></div>
                                <div>
                                    <p class="font-bold text-sm text-gray-600">Sedang Menunggu...</p>
                                    <p class="text-[10px]">Layar refresh otomatis tiap 15 detik</p>
                                </div>
                            </div>
                            <script>setTimeout(function(){window.location.reload(1);}, 15000);</script>
                        @endif
                    </div>
                </div>

            @else
                
                {{-- TOMBOL AMBIL ANTRIAN (Jika tidak ada antrian aktif) --}}
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-xl text-sm font-bold shadow-sm flex justify-between items-center">
                        <span>{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-green-800">&times;</button>
                    </div>
                @endif

                <form action="{{ route('queue.store') }}" method="POST">
                    @csrf
                    <button class="group w-full relative overflow-hidden bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-3xl p-6 text-left shadow-xl shadow-indigo-200 active:scale-95 transition-all duration-200 hover:shadow-2xl">
                        {{-- Hiasan --}}
                        <div class="absolute right-0 top-0 h-full w-32 bg-white/10 transform skew-x-12 translate-x-10 group-hover:translate-x-5 transition duration-500"></div>
                        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-indigo-500 rounded-full blur-2xl opacity-50"></div>
                        
                        <div class="relative z-10 flex items-center justify-between">
                            <div>
                                <div class="inline-block bg-indigo-500/30 backdrop-blur rounded px-2 py-1 mb-2">
                                    <p class="text-indigo-100 text-[10px] font-bold uppercase tracking-widest">Siap Muat Penumpang?</p>
                                </div>
                                <h3 class="text-white text-3xl font-black italic tracking-tight">AMBIL ANTRIAN</h3>
                                <p class="text-indigo-200 text-sm mt-1 group-hover:text-white transition">Klik di sini untuk dapat nomor</p>
                            </div>
                            <div class="bg-white/20 w-16 h-16 rounded-2xl rotate-3 flex items-center justify-center text-3xl shadow-lg border border-white/10 group-hover:rotate-6 transition">
                                🎫
                            </div>
                        </div>
                    </button>
                </form>

            @endif

            {{-- MENU GRID (Profil, Riwayat, Refresh) --}}
            {{-- Ditaruh di sini agar TETAP MUNCUL meski sedang antri --}}
            <div class="grid grid-cols-3 gap-3 mt-2">
                
                {{-- Profil --}}
                <a href="{{ route('driver.profile') }}" class="bg-white p-3 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-1 active:bg-gray-50 hover:border-indigo-100 transition">
                    <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-lg">👤</div>
                    <span class="text-[10px] font-bold text-gray-600">Profil</span>
                </a>

                {{-- Riwayat (NEW) --}}
                <a href="{{ route('driver.ritase.index') }}" class="bg-white p-3 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-1 active:bg-gray-50 hover:border-indigo-100 transition">
                    <div class="w-8 h-8 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-lg">📜</div>
                    <span class="text-[10px] font-bold text-gray-600">Riwayat</span>
                </a>

                {{-- Refresh --}}
                <a href="{{ route('dashboard') }}" class="bg-white p-3 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-1 active:bg-gray-50 hover:border-indigo-100 transition">
                    <div class="w-8 h-8 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center text-lg">🔄</div>
                    <span class="text-[10px] font-bold text-gray-600">Refresh</span>
                </a>
            </div>

        @endif
        
        <div class="text-center pb-4">
            <p class="text-[10px] text-gray-400">Sistem Antrian & Ritase v2.0</p>
        </div>
    </div>
</x-app-layout>