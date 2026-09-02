<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-bold text-xs rounded transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-1']) }}>
    {{ $slot }}
</button>
