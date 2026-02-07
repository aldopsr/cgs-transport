<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            🏢 Control Center Admin
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-blue-600 rounded-xl p-6 text-white shadow-lg">
                    <h3 class="font-bold text-blue-200 uppercase text-xs">Total Ritase Hari Ini</h3>
                    <p class="text-4xl font-black mt-2">{{ $totalRitase }} <span class="text-lg font-normal">Trip</span></p>
                </div>
                <div class="bg-emerald-500 rounded-xl p-6 text-white shadow-lg">
                    <h3 class="font-bold text-emerald-100 uppercase text-xs">Driver Aktif (Verified)</h3>
                    <p class="text-4xl font-black mt-2">{{ $driverActive }} <span class="text-lg font-normal">Orang</span></p>
                </div>
                <div class="bg-purple-500 rounded-xl p-6 text-white shadow-lg">
                    <h3 class="font-bold text-purple-200 uppercase text-xs">Antrian Menunggu</h3>
                    <p class="text-4xl font-black mt-2">{{ $queues->count() }} <span class="text-lg font-normal">Antrian</span></p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="bg-yellow-100 px-6 py-4 border-b border-yellow-200">
                            <h3 class="font-bold text-yellow-800 flex items-center gap-2">
                                🔔 Request Absensi Masuk ({{ $pendingAttendances->count() }})
                            </h3>
                        </div>
                        <div class="p-6">
                            @forelse($pendingAttendances as $absen)
                                <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4 last:mb-0 last:border-0 last:pb-0">
                                    <div class="flex items-center gap-4">
                                        <a href="{{ asset('storage/' . $absen->payment_proof) }}" target="_blank" class="block w-16 h-16 bg-gray-200 rounded-lg overflow-hidden shrink-0 hover:opacity-75 transition">
                                            <img src="{{ asset('storage/' . $absen->payment_proof) }}" class="w-full h-full object-cover">
                                        </a>
                                        <div>
                                            <h4 class="font-bold text-gray-800">{{ $absen->user->name }}</h4>
                                            <p class="text-xs text-gray-500">{{ $absen->user->nopol }} • {{ $absen->created_at->format('H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <form action="{{ route('attendance.verify', $absen->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button name="status" value="verified" class="bg-green-500 hover:bg-green-600 text-white text-xs font-bold py-1 px-3 rounded shadow w-20">
                                                TERIMA
                                            </button>
                                        </form>
                                        <form action="{{ route('attendance.verify', $absen->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button name="status" value="rejected" class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-1 px-3 rounded shadow w-20">
                                                TOLAK
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-400">
                                    <p>Tidak ada request absen baru.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="font-bold text-gray-700 mb-4">🚛 5 Ritase Terakhir</h3>
                        <div class="space-y-3">
                            @foreach($recentRitases as $trip)
                                <div class="flex justify-between items-center text-sm border-b pb-2 last:border-0">
                                    <div>
                                        <span class="font-bold text-gray-800">{{ $trip->user->name }}</span>
                                        <span class="text-gray-500">ke {{ $trip->tujuan }}</span>
                                    </div>
                                    <span class="text-gray-400 text-xs">{{ $trip->created_at->format('H:i') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-indigo-100 px-6 py-4 border-b border-indigo-200 flex justify-between items-center">
                        <h3 class="font-bold text-indigo-900">🚦 Manajemen Antrian</h3>
                        <span class="text-xs font-bold bg-indigo-200 text-indigo-800 px-2 py-1 rounded">
                            {{ $queues->count() }} Menunggu
                        </span>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @forelse($queues as $q)
                            <div class="p-6 flex flex-col sm:flex-row items-center justify-between gap-4 {{ $q->status == 'dipanggil' ? 'bg-green-50' : '' }}">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center font-black text-xl {{ $q->status == 'dipanggil' ? 'bg-green-500 text-white animate-pulse' : 'bg-gray-200 text-gray-600' }}">
                                        {{ $q->queue_number }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-lg text-gray-800">{{ $q->user->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $q->user->nopol }}</p>
                                        @if($q->status == 'dipanggil')
                                            <span class="text-xs font-bold text-green-600 uppercase tracking-wide">Sedang Dipanggil...</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 w-full sm:w-auto">
                                    @if($q->status == 'menunggu')
                                        <form action="{{ route('queue.update', $q->id) }}" method="POST" class="w-full">
                                            @csrf
                                            <button name="status" value="dipanggil" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow">
                                                📢 PANGGIL
                                            </button>
                                        </form>
                                    @elseif($q->status == 'dipanggil')
                                        <a href="{{ route('ritase.create', $q->id) }}" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow text-center">
                                            📝 JALAN
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <p class="text-gray-400 text-lg">Antrian Kosong 🍃</p>
                                <p class="text-gray-300 text-sm">Belum ada driver yang ambil nomor.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <script>
        setTimeout(function(){
           window.location.reload(1);
        }, 30000); // Refresh otomatis setiap 30 detik
    </script>
</x-app-layout>