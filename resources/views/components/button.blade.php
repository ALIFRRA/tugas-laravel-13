@props([
    'variant' => 'primary',
    'type' => 'submit',
    'href' => null,
])

@php
    $base = 'inline-flex items-center justify-center px-4 py-2 text-xs font-semibold rounded transition-colors shadow-sm';
    $variants = [
        'primary' => 'bg-pink-500 hover:bg-pink-600 text-white',
        'secondary' => 'bg-white hover:bg-slate-50 text-slate-700 border border-slate-300',
        'danger' => 'bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200',
    ];
    $class = $base . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </button>
@endif
