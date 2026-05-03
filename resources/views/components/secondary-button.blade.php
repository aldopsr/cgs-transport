<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-4 bg-white border border-black/10 rounded-2xl font-semibold text-sm text-[#0d1117] tracking-tight hover:bg-gray-50 active:scale-95 transition duration-150 ease-in-out w-full shadow-sm']) }}>
    {{ $slot }}
</button>