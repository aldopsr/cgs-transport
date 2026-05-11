<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-6"> 
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div class="animate-rise">
                    <h2 class="font-serif italic text-2xl text-[#0d1117]">
                        Dashboard  <span class="text-[#1a6bff] font-serif italic">Admin</span>
                    </h2>
                    <p class="text-sm text-gray-500">Ringkasan operasional bandara</p>
                </div>
                
                <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-3 bg-white p-3 rounded-xl shadow-sm border border-black/5 animate-rise">
                    <div class="flex flex-col">
                        <label class="text-[9px] uppercase font-bold text-gray-400 tracking-wider">Pilih Tanggal</label>
                        <input type="date" name="date" value="{{ $date }}" 
                            class="border-none p-0 text-gray-800 font-bold focus:ring-0 cursor-pointer bg-transparent text-sm"
                            onchange="this.form.submit()">
                    </div>
                    <div class="w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </form>
            </div>

            {{-- Stat Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 relative group hover:shadow-md transition border border-black/5 animate-rise">
                    <div class="text-gray-400 text-[10px] font-bold uppercase mb-1 tracking-wider">Total Antrian</div>
                    <div class="flex justify-between items-center">
                        <div class="text-4xl font-black text-gray-800">{{ $queues->count() }}</div>
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-[#1a6bff] group-hover:text-white transition">
                            <svg class="w-5 h-5 text-[#1a6bff] group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-[#1a6bff] rounded-b-2xl"></div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 relative group hover:shadow-md transition border border-black/5 animate-rise">
                    <div class="text-gray-400 text-[10px] font-bold uppercase mb-1 tracking-wider">Trip Selesai</div>
                    <div class="flex justify-between items-center">
                        <div class="text-4xl font-black text-gray-800">{{ $totalRitase }}</div>
                        <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition">
                            <svg class="w-5 h-5 text-purple-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-purple-500 rounded-b-2xl"></div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 relative group hover:shadow-md transition border border-black/5 animate-rise">
                    <div class="text-gray-400 text-[10px] font-bold uppercase mb-1 tracking-wider">Driver Aktif</div>
                    <div class="flex justify-between items-center">
                        <div class="text-4xl font-black text-gray-800">{{ $driverActive }}</div>
                        <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center group-hover:bg-yellow-500 group-hover:text-white transition">
                            <svg class="w-5 h-5 text-yellow-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-yellow-500 rounded-b-2xl"></div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 relative group hover:shadow-md transition border border-black/5 animate-rise">
                    <div class="text-gray-400 text-[10px] font-bold uppercase mb-1 tracking-wider">Omzet</div>
                    <div class="flex justify-between items-center">
                        <div class="text-xl font-black text-green-600 truncate">
                            Rp {{ number_format($revenue, 0, ',', '.') }}
                        </div>
                        <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition">
                            <svg class="w-5 h-5 text-green-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-green-500 rounded-b-2xl"></div>
                </div>
            </div>

            {{-- Grafik & Live Queue --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Grafik Ritase per Jam --}}
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6 border border-black/5 animate-rise">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Statistik Trip per Jam
                        </h3>
                        <span class="text-[10px] font-mono bg-gray-100 text-gray-600 px-3 py-1 rounded-full border border-gray-200">
                            {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}
                        </span>
                    </div>
                    <div class="relative h-80 w-full">
                        <canvas id="ritaseChart"></canvas>
                    </div>
                </div>

                {{-- Log Antrian --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 flex flex-col border border-black/5 h-[450px] animate-rise">
                    <div class="flex justify-between items-center mb-4 flex-shrink-0">
                        <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#1a6bff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Log Antrian
                        </h3>
                        @if($date == date('Y-m-d'))
                            <span class="bg-green-100 text-green-700 text-[9px] px-2 py-1 rounded-full font-bold border border-green-200">LIVE</span>
                        @else
                            <span class="bg-gray-100 text-gray-600 text-[9px] px-2 py-1 rounded-full border border-gray-200">ARSIP</span>
                        @endif
                    </div>
                    
                    <div class="flex-grow space-y-3 overflow-y-auto pr-2 custom-scrollbar">
                        @forelse($queues as $q)
                            <div class="border rounded-xl p-3 flex justify-between items-center transition hover:shadow-sm 
                                {{ $q->status == 'dipanggil' ? 'bg-green-50 border-green-200' : 
                                   ($q->status == 'siap_siap' ? 'bg-yellow-50 border-yellow-200' : 
                                   ($q->status == 'dilewati' ? 'bg-red-50 border-red-200' : 'bg-white border-gray-100')) }}">
                                
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-black text-lg 
                                            {{ $q->status == 'dipanggil' ? 'text-green-700' : 
                                               ($q->status == 'dilewati' ? 'text-red-700' : 'text-gray-800') }}">
                                            #{{ $q->queue_number }}
                                        </span>
                                        
                                        @if($q->status == 'dipanggil')
                                            <span class="text-[9px] bg-green-500 text-white px-2 py-0.5 rounded-full font-bold">DIPANGGIL</span>
                                        @elseif($q->status == 'selesai')
                                            <span class="text-[9px] bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full font-bold">SELESAI</span>
                                        @elseif($q->status == 'siap_siap')
                                            <span class="text-[9px] bg-yellow-400 text-yellow-900 px-2 py-0.5 rounded-full font-bold animate-pulse">SIAP SIAP</span>
                                        @elseif($q->status == 'dilewati')
                                            <span class="text-[9px] bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-bold">DILEWATI</span>
                                        @else
                                            <span class="text-[9px] bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full font-bold">MENUNGGU</span>
                                        @endif
                                    </div>
                                    <p class="text-sm font-bold text-gray-700 leading-tight">{{ $q->user->name ?? 'Driver' }}</p>
                                    <p class="text-[9px] text-gray-400 font-mono mt-0.5">{{ $q->user->nopol ?? '-' }}</p>
                                </div>

                                @if($date == date('Y-m-d') && in_array($q->status, ['menunggu', 'siap_siap']))
                                    <div class="flex flex-col gap-1">
                                        <form action="{{ route('queue.update', $q->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="dipanggil">
                                            <button class="w-full bg-[#1a6bff] hover:bg-[#0d5ae0] text-white text-[10px] font-bold py-1.5 px-3 rounded-lg shadow-sm transition active:scale-95">
                                                PANGGIL
                                            </button>
                                        </form>
                                        <form action="{{ route('queue.update', $q->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="dilewati">
                                            <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-600 text-[10px] font-bold py-1.5 px-3 rounded-lg transition active:scale-95">
                                                SKIP
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="h-full flex flex-col items-center justify-center text-center text-gray-400 border-2 border-dashed border-gray-100 rounded-xl bg-gray-50 py-12">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="text-sm">Tidak ada antrian</p>
                                <p class="text-xs opacity-60">pada tanggal ini</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Verifikasi Absensi --}}
            @if(isset($pendingAttendances) && $pendingAttendances->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-yellow-100 relative overflow-hidden animate-rise">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-yellow-400 opacity-10 rounded-bl-full -mr-10 -mt-10"></div>
                    
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2 relative z-10">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        Permintaan Verifikasi
                        <span class="bg-yellow-100 text-yellow-800 text-[10px] px-2 py-0.5 rounded-full">{{ $pendingAttendances->count() }} Pending</span>
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 relative z-10">
                        @foreach($pendingAttendances as $attendance)
                            <div class="border border-yellow-200 bg-yellow-50/50 rounded-xl p-4 flex gap-4 items-start shadow-sm hover:shadow-md transition">
                                <div class="w-16 h-16 bg-white rounded-lg overflow-hidden flex-shrink-0 cursor-pointer shadow-sm border border-gray-100 hover:scale-105 transition" 
                                     onclick="window.open('{{ asset('storage/'.$attendance->payment_proof) }}', '_blank')">
                                    <img src="{{ asset('storage/'.$attendance->payment_proof) }}" class="w-full h-full object-cover" alt="Bukti">
                                </div>
                                <div class="flex-grow">
                                    <p class="font-bold text-gray-800 text-sm">{{ $attendance->user->name }}</p>
                                    <p class="text-xs text-gray-500 mb-3">{{ $attendance->created_at->format('H:i') }} WIB</p>
                                    
                                    <div class="flex gap-2">
                                        <form action="{{ route('attendance.verify', $attendance->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('PATCH')
                                            <button class="w-full bg-green-600 text-white py-1.5 rounded-lg text-[9px] font-bold hover:bg-green-700 transition shadow-sm">TERIMA</button>
                                        </form>
                                        <form action="{{ route('attendance.reject', $attendance->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('PATCH')
                                            <button class="w-full bg-white border border-red-200 text-red-500 py-1.5 rounded-lg text-[9px] font-bold hover:bg-red-50 transition shadow-sm">TOLAK</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Script Chart --}}
    <script>
        const ctx = document.getElementById('ritaseChart').getContext('2d');
        
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(26, 107, 255, 0.5)');
        gradient.addColorStop(1, 'rgba(26, 107, 255, 0.05)');

        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($hours),
                datasets: [{
                    label: 'Trip',
                    data: @json($chartCounts),
                    backgroundColor: gradient,
                    borderColor: '#1a6bff',
                    borderWidth: 2,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#1a6bff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleColor: '#f3f4f6',
                        bodyColor: '#f3f4f6',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.raw + ' Trip Selesai';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [2, 4], color: '#f3f4f6', drawBorder: false },
                        ticks: { stepSize: 1, color: '#9ca3af', font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: '#9ca3af', maxTicksLimit: 8, font: { size: 11 } }
                    }
                }
            }
        });
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
    </style>
</x-app-layout>