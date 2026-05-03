<x-app-layout>
    @php
        $today = date('Y-m-d');
        $user_id = Auth::id();
        
        $attendance = App\Models\Attendance::where('user_id', $user_id)->where('date', $today)->first();
        
        $activeQueue = App\Models\Queue::where('user_id', $user_id)
                        ->whereDate('created_at', $today)
                        ->whereIn('status', ['menunggu', 'siap_siap', 'dipanggil']) 
                        ->first();

        $ritaseQuery = App\Models\Ritase::where('user_id', $user_id)->whereDate('created_at', $today);
        $ritaseCount = $ritaseQuery->count();
        $revenueToday = $ritaseQuery->sum('pendapatan');
    @endphp

    {{-- Hero Section --}}
    <div class="bg-gradient-to-r from-[#1a6bff] to-[#0d5ae0] pt-8 pb-16 rounded-b-3xl px-5 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-blue-500/30 rounded-full -ml-24 -mb-24"></div>
        
        <div class="relative z-10">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-blue-100 text-xs font-medium mb-1">Dashboard Driver</p>
                    <h1 class="text-2xl font-serif italic text-white">Halo, {{ explode(' ', Auth::user()->name)[0] }}</h1>
                    <div class="mt-3 flex items-center gap-2">
                        <div class="bg-white/20 rounded-full px-3 py-1">
                            <span class="text-[10px] text-white/70">Nopol</span>
                            <span class="text-xs font-mono font-bold text-white ml-1">{{ Auth::user()->nopol }}</span>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('driver.profile') }}" class="w-14 h-14 rounded-full bg-white/20 backdrop-blur-sm border-2 border-white/30 flex items-center justify-center overflow-hidden">
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-2xl font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    @endif
                </a>
            </div>
        </div>
    </div>

    <div class="px-5 -mt-8 pb-24 space-y-5">
        
        {{-- Stat Cards --}}
        <div class="grid grid-cols-3 gap-3">
            <div class="bg-white rounded-2xl p-4 shadow-md border-l-4 border-[#1a6bff]">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total Trip</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $ritaseCount }}</p>
                <p class="text-[9px] text-gray-400 mt-1">hari ini</p>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-md border-l-4 border-green-500">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Omzet</p>
                <p class="text-base font-bold text-green-600 mt-1">Rp {{ number_format($revenueToday, 0, ',', '.') }}</p>
                <p class="text-[9px] text-gray-400 mt-1">hari ini</p>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-md border-l-4 border-yellow-500">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Status</p>
                <div class="mt-1">
                    @if(!$attendance)
                        <span class="inline-block text-[10px] font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded-lg">Belum Absen</span>
                    @elseif($attendance->status == 'pending')
                        <span class="inline-block text-[10px] font-bold text-yellow-600 bg-yellow-50 px-2 py-1 rounded-lg">Pending</span>
                    @elseif($attendance->status == 'verified')
                        <span class="inline-block text-[10px] font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg">Aktif</span>
                    @else
                        <span class="inline-block text-[10px] font-bold text-red-600 bg-red-50 px-2 py-1 rounded-lg">Ditolak</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Konten Utama --}}
        @if(!$attendance || $attendance->status != 'verified')
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-white px-5 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">Absensi Harian</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Upload bukti setoran untuk mulai operasional</p>
                </div>

                <div class="p-5">
                    @if(!$attendance || $attendance->status == 'rejected')
                        <form action="{{ route('attendance.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-5">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">
                                    Bukti Setoran
                                </label>
                                <div onclick="document.getElementById('payment_proof').click()"
                                     class="border-2 border-dashed border-blue-200 rounded-xl p-6 text-center cursor-pointer hover:border-[#1a6bff] transition bg-blue-50/30 hover:bg-blue-50">
                                    <svg class="w-10 h-10 mx-auto mb-2 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p id="upload-label" class="text-sm text-gray-600 font-medium">Klik untuk upload foto</p>
                                    <p class="text-xs text-gray-400 mt-1">Foto bukti transfer setoran harian</p>
                                    <input type="file" id="payment_proof" name="payment_proof" accept="image/*" required class="hidden"
                                           onchange="document.getElementById('upload-label').innerHTML = '✓ ' + this.files[0].name;">
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-gradient-to-r from-[#1a6bff] to-[#0d5ae0] hover:from-[#0d5ae0] hover:to-[#1a6bff] text-white font-bold py-3 rounded-xl transition text-sm shadow-md">
                                MULAI OPERASIONAL
                            </button>
                        </form>
                    @elseif($attendance->status == 'pending')
                        <div class="text-center py-6">
                            <div class="w-16 h-16 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-yellow-500 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                            </div>
                            <p class="font-bold text-gray-800">Menunggu Verifikasi Admin</p>
                            <p class="text-sm text-gray-400 mt-1">Bukti setoran sedang diperiksa</p>
                            <button onclick="window.location.reload()" class="mt-5 text-[#1a6bff] text-sm font-bold flex items-center gap-1 mx-auto">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Refresh Status
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @else
            {{-- Info Sukses --}}
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 rounded-xl p-4 shadow-sm">
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Antrian Aktif --}}
            @if($activeQueue)
                <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-5 py-4 flex justify-between items-center">
                        <div>
                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Nomor Antrian</p>
                            <p class="text-xs text-gray-300">Anda dalam antrian</p>
                        </div>
                        @if($activeQueue->status == 'menunggu')
                            <span class="text-[10px] font-bold text-gray-300 bg-white/10 px-3 py-1 rounded-full">Menunggu</span>
                        @elseif($activeQueue->status == 'siap_siap')
                            <span class="text-[10px] font-bold text-yellow-700 bg-yellow-100 px-3 py-1 rounded-full">SIAP SIAP</span>
                        @elseif($activeQueue->status == 'dipanggil')
                            <span class="text-[10px] font-bold text-green-700 bg-green-100 px-3 py-1 rounded-full animate-pulse">DIPANGGIL</span>
                        @endif
                    </div>

                    <div class="py-10 text-center bg-gradient-to-b from-white to-gray-50">
                        <p class="text-8xl font-black text-gray-800 tracking-tighter">{{ $activeQueue->queue_number }}</p>
                        <p class="text-xs text-gray-400 mt-2">antrian Anda</p>
                    </div>

                    <div class="px-5 pb-6">
                        @if($activeQueue->status == 'dipanggil')
                            <div class="bg-green-50 rounded-xl p-4 text-center mb-4 border border-green-200">
                                <p class="font-bold text-green-700 text-lg">Penumpang Datang!</p>
                                <p class="text-sm text-green-600">Silakan muat penumpang</p>
                            </div>
                            <a href="{{ route('driver.ritase.create') }}" class="block w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 rounded-xl text-center shadow-md transition">
                                SELESAIKAN PERJALANAN
                            </a>

                        @elseif($activeQueue->status == 'siap_siap')
                            <div class="bg-yellow-50 rounded-xl p-4 text-center border border-yellow-200">
                                <p class="font-bold text-yellow-700 text-lg animate-pulse">SIAP SIAP!</p>
                                <p class="text-sm text-yellow-600">Giliran Anda sebentar lagi</p>
                                <p class="text-xs text-yellow-500 mt-2">Siapkan kendaraan Anda</p>
                            </div>
                            <script>setTimeout(function(){ window.location.reload(); }, 15000);</script>

                        @else
                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-ping"></div>
                                    <p class="text-gray-600 font-medium">Menunggu giliran...</p>
                                </div>
                                <p class="text-xs text-gray-400">Halaman refresh otomatis tiap 15 detik</p>
                            </div>
                            <script>setTimeout(function(){ window.location.reload(); }, 15000);</script>
                        @endif
                    </div>
                </div>

            @else
                {{-- Tombol Ambil Antrian --}}
                <form action="{{ route('queue.store') }}" method="POST">
                    @csrf
                    <button class="w-full bg-gradient-to-r from-[#1a6bff] to-[#0d5ae0] rounded-2xl p-6 text-left shadow-lg hover:shadow-xl active:scale-98 transition-all">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-[10px] text-blue-100 font-bold uppercase tracking-wider mb-1">Siap Muat Penumpang</p>
                                <h3 class="text-2xl font-serif italic text-white">Ambil Antrian</h3>
                                <p class="text-xs text-blue-100 mt-2">Klik untuk mendapatkan nomor antrian</p>
                            </div>
                            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                        </div>
                    </button>
                </form>

                <div class="bg-blue-50 rounded-xl p-4 text-center border border-blue-100">
                    <p class="text-sm text-blue-700 font-medium">Sudah selesai antar jemput?</p>
                    <p class="text-xs text-blue-600 mt-1">Ambil antrian baru untuk perjalanan berikutnya</p>
                </div>
            @endif

            {{-- Menu Bawah --}}
            <div class="grid grid-cols-3 gap-3 mt-2">
                <a href="{{ route('driver.profile') }}" class="bg-white rounded-xl p-4 text-center shadow-md hover:shadow-lg transition border border-gray-100">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                        <svg class="w-5 h-5 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-gray-700">Profil</p>
                    <p class="text-[9px] text-gray-400 mt-0.5">data diri</p>
                </a>

                <a href="{{ route('driver.ritase.index') }}" class="bg-white rounded-xl p-4 text-center shadow-md hover:shadow-lg transition border border-gray-100">
                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-gray-700">Riwayat</p>
                    <p class="text-[9px] text-gray-400 mt-0.5">perjalanan</p>
                </a>

                <button onclick="window.location.reload()" class="bg-white rounded-xl p-4 text-center shadow-md hover:shadow-lg transition border border-gray-100">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                        <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-gray-700">Refresh</p>
                    <p class="text-[9px] text-gray-400 mt-0.5">update</p>
                </button>
            </div>
        @endif

        {{-- Footer --}}
        <div class="text-center pt-6 pb-4">
            <p class="text-[10px] text-gray-400">Sistem Operasional Bandara</p>
            <p class="text-[9px] text-gray-300 mt-1">PT CSG Trans</p>
        </div>
    </div>
</x-app-layout>