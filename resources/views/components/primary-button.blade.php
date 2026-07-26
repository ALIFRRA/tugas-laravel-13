<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center border border-shuka-pink bg-shuka-pink px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-pink-400 focus:outline-none focus:ring-2 focus:ring-shuka-pink focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
