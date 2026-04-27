<x-app-layout>
    <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 px-6 pt-12 pb-28 rounded-b-[3rem] shadow-xl text-center relative z-10 overflow-hidden">
        {{-- Hiasan Background biar lebih estetik --}}
        <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-32 h-32 bg-indigo-500/30 rounded-full blur-xl"></div>

        <div class="relative z-10">
            <h2 class="text-white font-black text-2xl tracking-wide">Data Diri</h2>
            <p class="text-indigo-200 text-sm mt-1">Informasi Akun & Kendaraan</p>
        </div>
    </div>

    <div class="px-5 -mt-20 pb-20 relative z-20">
        
        <div class="bg-white rounded-3xl shadow-xl p-6 text-center mb-6 relative">
            
            <div class="w-28 h-28 bg-gray-100 rounded-full flex items-center justify-center text-5xl border-[6px] border-white shadow-lg absolute -top-14 left-1/2 transform -translate-x-1/2 overflow-hidden">
                @if($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="w-full h-full object-cover">
                @else
                    <span class="opacity-50 text-4xl">🤠</span>
                @endif
            </div>

            <div class="mt-14"></div> 
            
            <h3 class="font-black text-2xl text-gray-800">{{ $user->name }}</h3>
            <p class="text-gray-500 text-sm">{{ $user->email }}</p>
            <div class="mt-3 inline-block bg-indigo-50 text-indigo-700 px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest border border-indigo-100 shadow-sm">
                Mitra Driver
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-50">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between hover:bg-gray-50 transition">
                <span class="text-gray-500 text-xs font-bold uppercase tracking-wider">Plat Nomor</span>
                <span class="font-bold text-gray-800 font-mono text-lg bg-yellow-100 border border-yellow-300 px-3 py-0.5 rounded shadow-sm">{{ $user->nopol }}</span>
            </div>
            <div class="p-4 border-b border-gray-100 flex items-center justify-between hover:bg-gray-50 transition">
                <span class="text-gray-500 text-xs font-bold uppercase tracking-wider">No. HP</span>
                <span class="font-bold text-gray-800 font-mono text-base">{{ $user->phone }}</span>
            </div>
            <div class="p-4 border-b border-gray-100 flex items-center justify-between hover:bg-gray-50 transition">
                <span class="text-gray-500 text-xs font-bold uppercase tracking-wider">Status Akun</span>
                <span class="font-bold text-green-600 bg-green-50 px-3 py-1 rounded-full text-xs flex items-center gap-1">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> Aktif
                </span>
            </div>
            <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                <span class="text-gray-500 text-xs font-bold uppercase tracking-wider">Bergabung Sejak</span>
                <span class="font-bold text-gray-600 text-sm">{{ $user->created_at->format('d M Y') }}</span>
            </div>
        </div>

        <div class="mt-8 space-y-3">
            <a href="{{ route('dashboard') }}" class="flex items-center justify-center gap-2 w-full bg-slate-800 text-white font-bold py-4 rounded-2xl shadow-lg active:scale-95 transition hover:bg-slate-700">
                ⬅️ Kembali ke Dashboard
            </a>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex items-center justify-center gap-2 w-full bg-red-50 text-red-600 font-bold py-4 rounded-2xl border border-red-100 active:bg-red-100 transition hover:bg-red-100/50">
                    🚪 Logout (Keluar)
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6 leading-relaxed">
            *Jika ada kesalahan data atau ganti kendaraan,<br>hubungi Admin untuk perubahan.
        </p>
    </div>
</x-app-layout>