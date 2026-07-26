@props(['user' => null, 'size' => 'md'])

@php
    $user = $user ?? Auth::user();
    $sizes = [
        'sm' => 'h-8 w-8',
        'md' => 'h-10 w-10',
        'lg' => 'h-16 w-16',
    ];
    $class = $sizes[$size] ?? $sizes['md'];
@endphp

<img
    src="{{ $user?->avatarUrl() ?? asset('images/bocchi.png') }}"
    alt="{{ $user?->name ?? 'Bocchi' }}"
    {{ $attributes->merge(['class' => $class.' rounded-full object-contain object-bottom border border-shuka-line bg-shuka-soft']) }}
>
