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
    <div class="bg-[#1a6bff] pt-8 pb-14 rounded-b-[2.5rem] px-6 relative overflow-hidden shadow-lg shadow-blue-900/20">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-24 -mt-24"></div>
        
        <div class="relative z-10">
            <div class="flex justify-between items-center">
                <div class="animate-rise">
                    <p class="text-blue-100/80 text-[10px] font-bold uppercase tracking-[0.2em] mb-1">PT CSG Trans</p>
                    <h1 class="text-3xl font-serif italic text-white">Halo, {{ explode(' ', Auth::user()->name)[0] }}.</h1>
                    <div class="mt-4 inline-flex items-center bg-white/10 backdrop-blur-md rounded-xl px-3 py-1.5 border border-white/10">
                        <span class="text-[9px] text-blue-100 font-bold uppercase tracking-wider">Nopol:</span>
                        <span class="text-xs font-mono font-black text-white ml-2">{{ Auth::user()->nopol }}</span>
                    </div>
                </div>
                
                <a href="{{ route('driver.profile') }}" class="relative group animate-rise" style="animation-delay: 0.1s">
                    <div class="absolute inset-0 bg-white/20 blur-xl group-hover:bg-white/40 transition-all rounded-full"></div>
                    <div class="relative w-16 h-16 rounded-2xl border-2 border-white/30 overflow-hidden shadow-2xl transform transition group-active:scale-90">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-xl">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="px-6 -mt-8 pb-24 space-y-6">
        
        {{-- Stat Cards --}}
        <div class="grid grid-cols-3 gap-3 animate-rise" style="animation-delay: 0.2s">
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-black/5">
                <svg class="w-4 h-4 text-gray-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-1">Trip</p>
                <p class="text-xl font-black text-[#0d1117]">{{ $ritaseCount }}</p>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm border border-black/5">
                <svg class="w-4 h-4 text-gray-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-1">Omzet</p>
                <p class="text-sm font-black text-green-600">Rp {{ number_format($revenueToday, 0, ',', '.') }}</p>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm border border-black/5">
                <svg class="w-4 h-4 text-gray-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-1">Status</p>
                <div>
                    @if(!$attendance)
                        <span class="text-[9px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full uppercase">Offline</span>
                    @elseif($attendance->status == 'pending')
                        <span class="text-[9px] font-bold text-yellow-600 bg-yellow-50 px-2 py-0.5 rounded-full uppercase">Review</span>
                    @elseif($attendance->status == 'verified')
                        <span class="text-[9px] font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full uppercase">Aktif</span>
                    @else
                        <span class="text-[9px] font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full uppercase">Error</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Konten Utama --}}
        <div class="animate-rise" style="animation-delay: 0.3s">
            @if(!$attendance || $attendance->status != 'verified')
                <div class="bg-white rounded-[2rem] shadow-xl shadow-blue-900/5 border border-black/5 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#0d1117]">Absensi Harian</h3>
                                <p class="text-[11px] text-gray-400">Wajib upload bukti setoran</p>
                            </div>
                        </div>

                        @if(!$attendance || $attendance->status == 'rejected')
                            <form action="{{ route('attendance.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-5">
                                    <div onclick="document.getElementById('payment_proof').click()"
                                         class="border-2 border-dashed border-gray-100 rounded-2xl p-8 text-center cursor-pointer hover:border-[#1a6bff] transition bg-gray-50/50 hover:bg-blue-50/30 group">
                                        <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                                            <svg class="w-6 h-6 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <p id="upload-label" class="text-xs text-gray-600 font-bold uppercase tracking-wider">Upload Bukti Setoran</p>
                                        <input type="file" id="payment_proof" name="payment_proof" accept="image/*" required class="hidden"
                                               onchange="document.getElementById('upload-label').innerHTML = '✓ ' + this.files[0].name; this.parentElement.classList.add('border-green-400')">
                                    </div>
                                </div>
                                <button type="submit" class="w-full bg-[#1a6bff] hover:bg-[#0d5ae0] text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-600/20 transition-all">
                                    MULAI OPERASIONAL
                                </button>
                            </form>
                        @elseif($attendance->status == 'pending')
                            <div class="text-center py-8">
                                <div class="w-20 h-20 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                                    <svg class="w-8 h-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                </div>
                                <p class="font-bold text-[#0d1117]">Sedang Diverifikasi</p>
                                <p class="text-xs text-gray-400 mt-1 px-10">Admin sedang memeriksa bukti setoran Anda. Mohon tunggu sebentar.</p>
                                <button onclick="window.location.reload()" class="mt-6 text-[#1a6bff] text-xs font-black uppercase tracking-widest flex items-center gap-2 mx-auto">
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
                {{-- Bagian Antrian Aktif --}}
                @if($activeQueue)
                    <div class="bg-white rounded-[2rem] shadow-xl shadow-blue-900/5 border border-black/5 overflow-hidden">
                        <div class="bg-[#0d1117] px-6 py-4 flex justify-between items-center">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Antrian Anda</p>
                            @php
                                $statusStyle = [
                                    'menunggu' => 'bg-white/10 text-white',
                                    'siap_siap' => 'bg-yellow-400 text-black',
                                    'dipanggil' => 'bg-green-500 text-white animate-pulse'
                                ][$activeQueue->status];
                            @endphp
                            <span class="text-[9px] font-black uppercase px-3 py-1 rounded-full {{ $statusStyle }}">
                                {{ str_replace('_', ' ', $activeQueue->status) }}
                            </span>
                        </div>

                        <div class="py-12 text-center">
                            <p class="text-8xl font-black text-[#0d1117] tracking-tighter">{{ $activeQueue->queue_number }}</p>
                            <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em] mt-2">Nomor Antrian</p>
                        </div>

                        <div class="px-6 pb-8">
                            @if($activeQueue->status == 'dipanggil')
                                <div class="bg-green-50 rounded-2xl p-5 text-center mb-5 border border-green-100">
                                    <p class="font-black text-green-700 uppercase tracking-tight">Penumpang Datang</p>
                                    <p class="text-xs text-green-600 mt-1">Silakan arahkan ke titik muat</p>
                                </div>
                                <a href="{{ route('driver.ritase.create') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-green-600/20 text-center transition">
                                    SELESAIKAN PERJALANAN
                                </a>
                            @else
                                <div class="bg-gray-50 rounded-2xl p-4 text-center border border-gray-100">
                                    <div class="flex items-center justify-center gap-3">
                                        <div class="flex gap-1">
                                            <div class="w-1.5 h-1.5 bg-blue-400 rounded-full animate-bounce"></div>
                                            <div class="w-1.5 h-1.5 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                            <div class="w-1.5 h-1.5 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 font-medium tracking-tight">Menunggu giliran otomatis...</p>
                                    </div>
                                </div>
                                <script>setTimeout(function(){ window.location.reload(); }, 15000);</script>
                            @endif
                        </div>
                    </div>
                @else
                    {{-- Tombol Ambil Antrian --}}
                    <form action="{{ route('queue.store') }}" method="POST">
                        @csrf
                        <button class="w-full bg-[#1a6bff] rounded-[2rem] p-8 text-left shadow-xl shadow-blue-600/20 hover:shadow-2xl active:scale-[0.98] transition-all group">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-[10px] text-blue-100 font-bold uppercase tracking-[0.2em] mb-2 opacity-80">Standby Service</p>
                                    <h3 class="text-3xl font-serif italic text-white">Ambil <span class="not-italic font-sans font-black">Antrian</span></h3>
                                </div>
                                <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center group-hover:scale-110 transition">
                                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </div>
                            </div>
                        </button>
                    </form>
                @endif
            @endif
        </div>

        {{-- Grid Menu Bawah --}}
        <div class="grid grid-cols-3 gap-3 animate-rise" style="animation-delay: 0.4s">
            <a href="{{ route('driver.profile') }}" class="bg-white rounded-[1.5rem] p-5 text-center shadow-sm border border-black/5 active:scale-95 transition-all">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <p class="text-xs font-bold text-gray-800">Profil</p>
            </a>

            <a href="{{ route('driver.ritase.index') }}" class="bg-white rounded-[1.5rem] p-5 text-center shadow-sm border border-black/5 active:scale-95 transition-all">
                <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-xs font-bold text-gray-800">Riwayat</p>
            </a>

            <button onclick="window.location.reload()" class="bg-white rounded-[1.5rem] p-5 text-center shadow-sm border border-black/5 active:scale-95 transition-all">
                <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
                <p class="text-xs font-bold text-gray-800">Update</p>
            </button>
        </div>

        {{-- Footer --}}
        <div class="text-center pt-8 pb-4">
            <p class="text-[9px] text-gray-400 uppercase tracking-[0.3em]">Official Driver Portal</p>
        </div>
    </div>
</x-app-layout>