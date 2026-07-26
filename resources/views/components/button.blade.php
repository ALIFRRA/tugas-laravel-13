@props([
    'variant' => 'primary',
    'type' => 'submit',
    'href' => null,
])

@php
    $base = 'inline-flex items-center justify-center px-4 py-2 text-sm font-medium transition border';
    $variants = [
        'primary' => 'border-shuka-pink bg-shuka-pink text-white hover:bg-pink-400',
        'secondary' => 'border-shuka-line bg-white text-slate-700 hover:border-shuka-pink hover:text-shuka-pink',
        'danger' => 'border-rose-300 bg-white text-rose-600 hover:bg-rose-50',
    ];
    $class = $base.' '.($variants[$variant] ?? $variants['primary']);
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
