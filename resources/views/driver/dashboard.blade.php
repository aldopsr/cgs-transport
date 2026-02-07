<x-app-layout>
    @php
        $today = date('Y-m-d');
        $attendance = App\Models\Attendance::where('user_id', Auth::id())->where('date', $today)->first();
        
        $activeQueue = App\Models\Queue::where('user_id', Auth::id())
                        ->whereDate('created_at', $today)
                        ->whereIn('status', ['menunggu', 'dipanggil'])
                        ->first();

        $ritaseCount = App\Models\Ritase::where('user_id', Auth::id())->whereDate('created_at', $today)->count();
    @endphp

    <div class="bg-indigo-600 pt-8 pb-16 rounded-b-[3rem] px-6 shadow-xl relative">
        <div class="flex justify-between items-start">
            <div class="text-white">
                <p class="text-indigo-200 text-sm">Halo, Driver</p>
                <h1 class="text-2xl font-bold leading-tight">{{ explode(' ', Auth::user()->name)[0] }}</h1>
                <div class="mt-2 inline-flex items-center bg-indigo-700 rounded-lg px-3 py-1 border border-indigo-500">
                    <span class="text-xs font-mono text-white tracking-widest">{{ Auth::user()->nopol }}</span>
                </div>
            </div>
            
            <a href="{{ route('driver.profile') }}" class="bg-white/10 p-2 rounded-xl backdrop-blur-sm border border-white/20 active:bg-white/20 transition">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-indigo-600 font-bold shadow-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </a>
        </div>
    </div>

    <div class="px-5 -mt-10 pb-20 relative z-10 space-y-5">

        <div class="bg-white rounded-3xl shadow-lg p-5 flex justify-between items-center">
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wide">Ritase Hari Ini</p>
                <p class="text-4xl font-black text-gray-800">{{ $ritaseCount }} <span class="text-sm font-normal text-gray-400">Trip</span></p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wide">Status Absen</p>
                <div class="mt-1">
                    @if(!$attendance) 
                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">Belum Absen</span>
                    @elseif($attendance->status == 'pending') 
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Verifikasi</span>
                    @elseif($attendance->status == 'verified') 
                        <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-bold">✅ Kerja</span>
                    @else 
                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">Ditolak</span>
                    @endif
                </div>
            </div>
        </div>

        @if(!$attendance || $attendance->status != 'verified')
            @if(!$attendance || $attendance->status == 'rejected')
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
                    <div class="bg-red-50 p-4 border-b border-red-100 text-center">
                        <p class="text-red-600 font-bold text-sm">⚠️ Operasional Belum Dimulai</p>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('attendance.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="block w-full h-32 border-2 border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center bg-gray-50 mb-4 cursor-pointer active:bg-gray-100">
                                <span class="text-3xl mb-1">📷</span>
                                <span class="text-xs text-gray-500 font-bold">Upload Bukti Transfer</span>
                                <input type="file" name="payment_proof" required class="hidden" onchange="this.previousElementSibling.previousElementSibling.innerHTML='✅'; this.previousElementSibling.innerHTML='Foto Siap!'; this.parentElement.classList.add('border-green-500', 'bg-green-50');">
                            </label>
                            <button class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl shadow-lg active:scale-95 transition">
                                MULAI KERJA (Kirim)
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-3xl p-8 text-center animate-pulse">
                    <span class="text-4xl block mb-2">⏳</span>
                    <h3 class="font-bold text-yellow-800">Menunggu Admin</h3>
                    <p class="text-xs text-yellow-600 mt-1">Data sedang diverifikasi...</p>
                </div>
            @endif

        @else
            @if($activeQueue)
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden text-center relative">
                    <div class="{{ $activeQueue->status == 'dipanggil' ? 'bg-green-500' : 'bg-indigo-600' }} py-3">
                        <p class="text-white text-xs font-bold uppercase tracking-widest opacity-80">Nomor Antrian</p>
                    </div>
                    <div class="py-8">
                        <span class="text-8xl font-black text-gray-800 tracking-tighter">{{ $activeQueue->queue_number }}</span>
                    </div>
                    <div class="px-4 pb-6">
                        @if($activeQueue->status == 'dipanggil')
                            <div class="bg-green-50 text-green-700 p-3 rounded-xl animate-bounce">
                                <p class="font-black text-lg">📢 SEGERA MASUK!</p>
                                <p class="text-xs">Giliran Anda muat barang.</p>
                            </div>
                        @else
                            <div class="bg-gray-100 text-gray-500 p-3 rounded-xl">
                                <p class="font-bold text-sm">Sedang Menunggu...</p>
                                <p class="text-[10px] mt-1">Layar refresh otomatis tiap 15 detik</p>
                            </div>
                            <script>setTimeout(function(){window.location.reload(1);}, 15000);</script>
                        @endif
                    </div>
                </div>

            @else
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl text-center text-sm font-bold mb-2">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('queue.store') }}" method="POST">
                    @csrf
                    <button class="group w-full relative overflow-hidden bg-indigo-600 rounded-3xl p-6 text-left shadow-xl shadow-indigo-200 active:scale-95 transition-all duration-200">
                        <div class="absolute right-0 top-0 h-full w-32 bg-white/10 transform skew-x-12 translate-x-10 group-active:translate-x-0 transition"></div>
                        
                        <div class="relative z-10 flex items-center justify-between">
                            <div>
                                <p class="text-indigo-200 text-xs font-bold uppercase mb-1">Siap Muat?</p>
                                <h3 class="text-white text-2xl font-black italic">AMBIL ANTRIAN</h3>
                                <p class="text-white/80 text-sm mt-1">Klik untuk dapat nomor</p>
                            </div>
                            <div class="bg-white/20 w-16 h-16 rounded-full flex items-center justify-center text-3xl shadow-inner">
                                🎫
                            </div>
                        </div>
                    </button>
                </form>

                <div class="grid grid-cols-2 gap-4 pt-2">
                    <a href="{{ route('driver.profile') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-2 active:bg-gray-50">
                        <span class="text-2xl">👤</span>
                        <span class="text-xs font-bold text-gray-600">Lihat Profil</span>
                    </a>
                     <a href="{{ route('dashboard') }}" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-2 active:bg-gray-50">
                        <span class="text-2xl">🔄</span>
                        <span class="text-xs font-bold text-gray-600">Refresh Data</span>
                    </a>
                </div>

            @endif
        @endif
        
    </div>
</x-app-layout>