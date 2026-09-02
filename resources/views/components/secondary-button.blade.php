<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 font-semibold text-xs rounded transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-300']) }}>
    {{ $slot }}
</button>
