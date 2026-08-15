@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 text-slate-900 bg-white']) }}>
