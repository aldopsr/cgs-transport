<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            ✏️ Edit Data Driver
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <form action="{{ route('drivers.update', $driver->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ $driver->name }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email Login</label>
                            <input type="email" name="email" value="{{ $driver->email }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4"> 
                            <label class="block text-gray-700 text-sm font-bold mb-2">No.Hp</label>
                            <input type="phone" name="phone" value="{{ $driver->phone }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-6 bg-yellow-50 p-4 rounded border border-yellow-200">
                            <label class="block text-gray-700 text-sm font-bold mb-2">🚚 Plat Nomor Kendaraan</label>
                            <input type="text" name="nopol" value="{{ $driver->nopol }}" required class="shadow appearance-none border border-yellow-400 rounded w-full py-2 px-3 text-gray-900 font-bold uppercase leading-tight focus:outline-none focus:shadow-outline">
                            <p class="text-xs text-gray-500 mt-1">Ubah jika driver ganti kendaraan.</p>
                        </div>

                        <div class="mb-6 border-t pt-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Reset Password (Opsional)</label>
                            <input type="password" name="password" placeholder="Isi hanya jika ingin mengganti password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('drivers.index') }}" class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Batal
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>