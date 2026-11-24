<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-pink-500 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:bg-pink-600 focus:bg-pink-600 active:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm cursor-pointer']) }}>
    {{ $slot }}
</button>
