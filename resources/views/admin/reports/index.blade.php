<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            📈 Laporan & Rekapitulasi
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
                    <div class="w-full md:w-1/3">
                        <label class="font-bold text-gray-700">Dari Tanggal:</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div class="w-full md:w-1/3">
                        <label class="font-bold text-gray-700">Sampai Tanggal:</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div class="w-full md:w-1/3 flex gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow w-full">
                            🔍 Filter Data
                        </button>
                        <button type="button" onclick="window.print()" class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-6 rounded-lg shadow w-full">
                            🖨️ Cetak
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-blue-50 flex justify-between items-center">
                    <h3 class="font-bold text-lg text-blue-900">Hasil Pencarian</h3>
                    <span class="bg-blue-200 text-blue-800 px-3 py-1 rounded-full font-bold text-sm">
                        Total: {{ $totalRitase }} Ritase
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-sm font-bold">
                            <tr>
                                <th class="px-6 py-3 border-b">Tanggal & Jam</th>
                                <th class="px-6 py-3 border-b">Nama Driver</th>
                                <th class="px-6 py-3 border-b">Nopol</th>
                                <th class="px-6 py-3 border-b">Tujuan</th>
                                <th class="px-6 py-3 border-b">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse($ritases as $data)
                                <tr class="hover:bg-gray-50 border-b last:border-0">
                                    <td class="px-6 py-4 font-mono text-sm">
                                        {{ $data->created_at->format('d/m/Y') }} <br>
                                        <span class="text-gray-400">{{ $data->created_at->format('H:i') }}</span>
                                    </td>
                                    <td class="px-6 py-4 font-bold">{{ $data->user->name }}</td>
                                    <td class="px-6 py-4 bg-gray-50 font-mono">{{ $data->user->nopol }}</td>
                                    <td class="px-6 py-4">{{ $data->tujuan }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $data->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                        Tidak ada data ritase pada rentang tanggal ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    
    <style>
        @media print {
            header, form, button { display: none !important; }
            body { background: white !important; }
            .shadow-lg, .shadow-md { box-shadow: none !important; }
        }
    </style>
</x-app-layout>