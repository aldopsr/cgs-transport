<x-app-layout>
    <div class="bg-indigo-600 px-6 pt-8 pb-12 rounded-b-[3rem] shadow-xl text-center relative z-10">
        <h2 class="text-white font-bold text-xl">👤 Data Diri</h2>
        <p class="text-indigo-200 text-sm">Informasi Akun & Kendaraan</p>
    </div>

    <div class="px-6 -mt-8 pb-20 relative z-20">
        
        <div class="bg-white rounded-3xl shadow-lg p-6 text-center mb-6">
            <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto flex items-center justify-center text-4xl border-4 border-white shadow-md -mt-16 mb-4">
                🤠
            </div>
            <h3 class="font-black text-2xl text-gray-800">{{ $user->name }}</h3>
            <p class="text-gray-500 text-sm">{{ $user->email }}</p>
            <div class="mt-4 inline-block bg-indigo-50 text-indigo-700 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                Driver Logistik
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <span class="text-gray-500 text-sm">Plat Nomor</span>
                <span class="font-bold text-gray-800 font-mono text-lg bg-yellow-100 px-2 rounded">{{ $user->nopol }}</span>
            </div>
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <span class="text-gray-500 text-sm">Status Akun</span>
                <span class="font-bold text-green-600">✅ Aktif</span>
            </div>
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <span class="text-gray-500 text-sm">Bergabung Sejak</span>
                <span class="font-bold text-gray-800">{{ $user->created_at->format('d M Y') }}</span>
            </div>
        </div>

        <div class="mt-8 space-y-4">
            <a href="{{ route('dashboard') }}" class="block w-full bg-gray-800 text-white text-center font-bold py-4 rounded-2xl shadow-lg active:scale-95 transition">
                ⬅️ Kembali ke Dashboard
            </a>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full bg-red-50 text-red-600 font-bold py-4 rounded-2xl border border-red-100 active:bg-red-100 transition">
                    🚪 Logout (Keluar)
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-400 mt-8">
            *Jika ada kesalahan data atau ganti kendaraan,<br>hubungi Admin untuk perubahan.
        </p>
    </div>
</x-app-layout>