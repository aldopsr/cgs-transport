<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-between px-6 py-4 bg-[#0d1117] border border-transparent rounded-2xl font-bold text-sm text-white tracking-tight hover:bg-[#1a2233] active:scale-95 transition duration-150 ease-in-out w-full shadow-lg shadow-black/10']) }}>
    {{ $slot }}
</button>