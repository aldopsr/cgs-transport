<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div>
                    <h2 class="font-bold text-2xl text-gray-800">📸 Riwayat Absensi</h2>
                    <p class="text-sm text-gray-500">Cek ulang bukti foto absen driver</p>
                </div>
                
                <form action="{{ route('admin.attendance.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="date" name="date" value="{{ request('date') }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                        Cari
                    </button>
                    @if(request('date'))
                        <a href="{{ route('admin.attendance.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-bold transition">Reset</a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-[10px] font-black tracking-wider">
                            <tr>
                                <th class="p-4 border-b">Tanggal & Waktu</th>
                                <th class="p-4 border-b">Nama Driver</th>
                                <th class="p-4 border-b">Status</th>
                                <th class="p-4 border-b text-center">Bukti Foto</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($attendances as $absen)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4">
                                    <div class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($absen->date)->isoFormat('D MMMM Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $absen->created_at->format('H:i') }} WIB</div>
                                </td>
                                <td class="p-4 font-bold text-gray-700">{{ $absen->user->name ?? 'Driver Tidak Ditemukan' }}</td>
                                <td class="p-4">
                                    @if($absen->status == 'verified')
                                        <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-bold">Terverifikasi</span>
                                    @elseif($absen->status == 'rejected')
                                        <span class="bg-red-100 text-red-700 px-2.5 py-1 rounded-full text-xs font-bold">Ditolak</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-full text-xs font-bold">Pending</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    @if($absen->payment_proof)
                                        <a href="{{ asset('storage/' . $absen->payment_proof) }}" target="_blank" class="inline-block bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded text-xs font-bold transition">
                                            👁️ Lihat Foto
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Tidak ada file</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-400">
                                    <span class="text-3xl mb-2 block">📭</span>
                                    Tidak ada data absensi yang ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($attendances->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50">
                        {{ $attendances->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>