<x-app-layout>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Active in Queue</p>
                    <h3 class="text-4xl font-black text-slate-800 mt-2">{{ $queues->count() }}</h3>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-xs text-green-600 font-bold">Live Monitoring</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Trips Completed</p>
                    <h3 class="text-4xl font-black text-slate-800 mt-2">{{ $totalRitase }}</h3>
                </div>
                <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-4">Total hari ini</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Drivers Verified</p>
                    <h3 class="text-4xl font-black text-slate-800 mt-2">{{ $driverActive }}</h3>
                </div>
                <div class="p-3 bg-yellow-50 text-yellow-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.131A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.2-2.873.571-4.205"></path></svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-4">Siap beroperasi</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Est. Revenue</p>
                    <h3 class="text-4xl font-black text-slate-800 mt-2">Rp -</h3>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-4">Belum ada data tarif</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-slate-800 text-lg">Live Queue Board</h3>
                    <span class="text-xs bg-blue-100 text-blue-700 font-bold px-3 py-1 rounded-full">Terminal 3</span>
                </div>

                <div class="space-y-3">
                    @forelse($queues as $q)
                        <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-blue-200 hover:shadow-md transition bg-white {{ $q->status == 'dipanggil' ? 'bg-green-50 border-green-200' : '' }}">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center font-black text-xl {{ $q->status == 'dipanggil' ? 'bg-green-500 text-white shadow-lg shadow-green-200' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $q->queue_number }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800">{{ $q->user->name }}</h4>
                                    <p class="text-xs text-slate-500 font-mono">{{ $q->user->nopol }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                @if($q->status == 'menunggu')
                                    <form action="{{ route('queue.update', $q->id) }}" method="POST">
                                        @csrf
                                        <button name="status" value="dipanggil" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-lg shadow-blue-200 transition">
                                            PANGGIL
                                        </button>
                                    </form>
                                @elseif($q->status == 'dipanggil')
                                    <a href="{{ route('ritase.create', $q->id) }}" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-lg shadow-green-200 transition flex items-center gap-1">
                                        DISPATCH 🚀
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                            <p class="text-gray-400 font-medium">No vehicles in queue.</p>
                        </div>
                    @endforelse
                </div>
            </div>

             <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-slate-800 text-lg mb-4">Recent Trips</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 rounded-l-lg">Driver</th>
                                <th class="px-4 py-3">Destination</th>
                                <th class="px-4 py-3 rounded-r-lg text-right">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRitases as $trip)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $trip->user->name }}</td>
                                    <td class="px-4 py-3">{{ $trip->tujuan }}</td>
                                    <td class="px-4 py-3 text-right">{{ $trip->created_at->format('H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-yellow-100 rounded-bl-full -mr-10 -mt-10 z-0"></div>
                <h3 class="font-bold text-slate-800 text-lg mb-4 relative z-10">Attendance Requests</h3>
                
                <div class="space-y-4 relative z-10">
                    @forelse($pendingAttendances as $absen)
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden">
                                     <img src="{{ asset('storage/' . $absen->payment_proof) }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm">{{ $absen->user->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $absen->created_at->format('d M, H:i') }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <form action="{{ route('attendance.verify', $absen->id) }}" method="POST" class="flex-1">
                                    @csrf @method('PATCH')
                                    <button name="status" value="verified" class="w-full bg-slate-900 hover:bg-black text-white text-xs font-bold py-2 rounded-lg">
                                        Accept
                                    </button>
                                </form>
                                <form action="{{ route('attendance.verify', $absen->id) }}" method="POST" class="flex-1">
                                    @csrf @method('PATCH')
                                    <button name="status" value="rejected" class="w-full bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-bold py-2 rounded-lg">
                                        Deny
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-4">All clear! No requests.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <script>
        setTimeout(function(){
           window.location.reload(1);
        }, 30000); 
    </script>
</x-app-layout>