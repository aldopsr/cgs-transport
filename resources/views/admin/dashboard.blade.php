<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
    <div class="py-6"> {{-- Padding disesuaikan --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- === BAGIAN BARU: JUDUL & FILTER TANGGAL (LANGSUNG DI BODY) === --}}
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div>
                    <h2 class="font-bold text-2xl text-gray-800">
                        🎛️ Dashboard
                    </h2>
                    <p class="text-sm text-gray-500">Ringkasan operasional bandara</p>
                </div>
                
                {{-- FORM FILTER TANGGAL --}}
                <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-3 bg-white p-3 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex flex-col">
                        <label class="text-[10px] uppercase font-bold text-gray-500 tracking-wider">Pilih Tanggal</label>
                        <input type="date" name="date" value="{{ $date }}" 
                            class="border-none p-0 text-gray-800 font-bold focus:ring-0 cursor-pointer bg-transparent"
                            onchange="this.form.submit()">
                    </div>
                    <div class="h-8 w-8 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600">
                        📅
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 relative group hover:shadow-md transition">
                    <div class="text-gray-500 text-xs font-bold uppercase mb-1 tracking-wider">Total Antrian</div>
                    <div class="flex justify-between items-center">
                        <div class="text-4xl font-black text-gray-800">{{ $queues->count() }}</div>
                        <div class="p-3 bg-blue-50 rounded-xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition">👥</div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500 rounded-b-2xl"></div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 relative group hover:shadow-md transition">
                    <div class="text-gray-500 text-xs font-bold uppercase mb-1 tracking-wider">Trip Selesai</div>
                    <div class="flex justify-between items-center">
                        <div class="text-4xl font-black text-gray-800">{{ $totalRitase }}</div>
                        <div class="p-3 bg-purple-50 rounded-xl text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition">🚕</div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-purple-500 rounded-b-2xl"></div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 relative group hover:shadow-md transition">
                    <div class="text-gray-500 text-xs font-bold uppercase mb-1 tracking-wider">Driver Aktif</div>
                    <div class="flex justify-between items-center">
                        <div class="text-4xl font-black text-gray-800">{{ $driverActive }}</div>
                        <div class="p-3 bg-yellow-50 rounded-xl text-yellow-600 group-hover:bg-yellow-600 group-hover:text-white transition">🆔</div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-yellow-500 rounded-b-2xl"></div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 relative group hover:shadow-md transition">
                    <div class="text-gray-500 text-xs font-bold uppercase mb-1 tracking-wider">Omzet</div>
                    <div class="flex justify-between items-center">
                        <div class="text-2xl font-black text-green-600 truncate">
                            Rp {{ number_format($revenue, 0, ',', '.') }}
                        </div>
                        <div class="p-3 bg-green-50 rounded-xl text-green-600 group-hover:bg-green-600 group-hover:text-white transition">💰</div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-green-500 rounded-b-2xl"></div>
                </div>
            </div>

            {{-- 2. GRAFIK & LIVE QUEUE --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- GRAFIK RITASE PER JAM --}}
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-gray-800 text-lg">📊 Statistik Trip per Jam</h3>
                        <span class="text-xs font-mono bg-gray-100 text-gray-600 px-3 py-1 rounded-full border border-gray-200">
                            {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}
                        </span>
                    </div>
                    <div class="relative h-80 w-full">
                        <canvas id="ritaseChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 flex flex-col border border-gray-100 h-[450px]">
                    <div class="flex justify-between items-center mb-4 flex-shrink-0">
                        <h3 class="font-bold text-gray-800 text-lg">🚦 Log Antrian</h3>
                        @if($date == date('Y-m-d'))
                            <span class="bg-green-100 text-green-700 text-[10px] px-2 py-1 rounded-full font-bold animate-pulse border border-green-200">LIVE</span>
                        @else
                            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-1 rounded-full border border-gray-200">ARSIP</span>
                        @endif
                    </div>
                    
                    <div class="flex-grow space-y-3 overflow-y-auto pr-2 custom-scrollbar">
                        @forelse($queues as $q)
                            <div class="border rounded-xl p-3 flex justify-between items-center transition hover:shadow-sm {{ $q->status == 'dipanggil' ? 'bg-green-50 border-green-200' : 'bg-white border-gray-100' }}">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-black text-lg {{ $q->status == 'dipanggil' ? 'text-green-700' : 'text-gray-800' }}">#{{ $q->queue_number }}</span>
                                        @if($q->status == 'dipanggil')
                                            <span class="text-[10px] bg-green-500 text-white px-2 py-0.5 rounded-full font-bold">DIPANGGIL</span>
                                        @elseif($q->status == 'selesai')
                                            <span class="text-[10px] bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full font-bold">SELESAI</span>
                                        @else
                                            <span class="text-[10px] bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full font-bold">MENUNGGU</span>
                                        @endif
                                    </div>
                                    <p class="text-sm font-bold text-gray-700 leading-tight">{{ $q->user->name ?? 'Driver' }}</p>
                                    <p class="text-[10px] text-gray-400 font-mono mt-0.5">{{ $q->user->nopol ?? '-' }}</p>
                                </div>

                                @if($date == date('Y-m-d') && $q->status == 'menunggu')
                                    <form action="{{ route('queue.update', $q->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="dipanggil">
                                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-sm transition transform active:scale-95">
                                            PANGGIL
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @empty
                            <div class="h-full flex flex-col items-center justify-center text-center text-gray-400 border-2 border-dashed border-gray-100 rounded-xl bg-gray-50">
                                <span class="text-4xl mb-2">📭</span>
                                <p class="text-sm">Tidak ada antrian</p>
                                <p class="text-xs opacity-60">pada tanggal ini</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            @if(isset($pendingAttendances) && $pendingAttendances->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-yellow-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-yellow-400 opacity-10 rounded-bl-full -mr-10 -mt-10"></div>
                    
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2 relative z-10">
                        🔔 Permintaan Verifikasi <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-0.5 rounded-full">{{ $pendingAttendances->count() }} Pending</span>
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 relative z-10">
                        @foreach($pendingAttendances as $attendance)
                            <div class="border border-yellow-200 bg-yellow-50/50 rounded-xl p-4 flex gap-4 items-start shadow-sm hover:shadow-md transition">
                                {{-- Bukti Transfer --}}
                                <div class="w-16 h-16 bg-white rounded-lg overflow-hidden flex-shrink-0 cursor-pointer shadow-sm border border-gray-100 hover:scale-105 transition" onclick="window.open('{{ asset('storage/'.$attendance->payment_proof) }}', '_blank')">
                                    <img src="{{ asset('storage/'.$attendance->payment_proof) }}" class="w-full h-full object-cover" alt="Bukti">
                                </div>
                                <div class="flex-grow">
                                    <p class="font-bold text-gray-800 text-sm">{{ $attendance->user->name }}</p>
                                    <p class="text-xs text-gray-500 mb-3">{{ $attendance->created_at->format('H:i') }} WIB</p>
                                    
                                    <div class="flex gap-2">
                                        <form action="{{ route('attendance.verify', $attendance->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button class="w-full bg-green-600 text-white py-1.5 rounded-lg text-[10px] font-bold hover:bg-green-700 transition shadow-sm">TERIMA</button>
                                        </form>
                                        <form action="{{ route('attendance.reject', $attendance->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button class="w-full bg-white border border-red-200 text-red-500 py-1.5 rounded-lg text-[10px] font-bold hover:bg-red-50 transition shadow-sm">TOLAK</button>
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

    {{-- SCRIPT CHART --}}
    <script>
        const ctx = document.getElementById('ritaseChart').getContext('2d');
        
        // Gradient untuk Chart
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(79, 70, 229, 0.5)'); // Indigo
        gradient.addColorStop(1, 'rgba(79, 70, 229, 0.05)');

        const myChart = new Chart(ctx, {
            type: 'line', 
            data: {
                labels: @json($hours), 
                datasets: [{
                    label: 'Trip',
                    data: @json($chartCounts),
                    backgroundColor: gradient,
                    borderColor: '#4f46e5',
                    borderWidth: 2,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4f46e5',
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
                                return '🚕 ' + context.raw + ' Trip Selesai';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [2, 4], color: '#f3f4f6', drawBorder: false },
                        ticks: { stepSize: 1, color: '#9ca3af', font: {family: "'Inter', sans-serif", size: 11} }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: '#9ca3af', maxTicksLimit: 8, font: {family: "'Inter', sans-serif", size: 11} }
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