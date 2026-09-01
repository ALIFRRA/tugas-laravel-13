<?php
@props([
    'src' => '',
    'alt' => '',
    'class' => '',
    'width' => null,
    'height' => null,
    'placeholder' => null,
    'loading' => 'lazy',
])

@php
    $style = '';
    if ($width) $style .= "width: {$width};";
    if ($height) $style .= "height: {$height};";
    $placeholderSrc = $placeholder ?? 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAFUlEQVR42mP8/5+hnoEIwDiqkL4KAcT9G0AB4Y9gZgABzQM2RIUFAAAAAElFTkSuQmCC';
@endphp

<div 
    class="relative overflow-hidden {{ $class }}"
    x-data="{ loaded: false, error: false }"
    @if($style) style="{{ $style }}" @endif
>
    <!-- Blur placeholder -->
    <img
        src="{{ $placeholderSrc }}"
        alt=""
        class="absolute inset-0 w-full h-full object-cover blur-[20px] scale-110 transition-opacity duration-500"
        :class="{ 'opacity-0': loaded || error, 'opacity-100': !loaded && !error }"
        aria-hidden="true"
    >

    <!-- Actual image -->
    <img
        src="{{ $src }}"
        alt="{{ $alt }}"
        class="absolute inset-0 w-full h-full object-cover transition-all duration-500"
        :class="{ 'opacity-100 scale-100': loaded, 'opacity-0 scale-95': !loaded }"
        @load="loaded = true"
        @error="error = true; loaded = true"
        :loading="{{ $loading }}"
        decoding="async"
    >

    <!-- Error fallback -->
    <div 
        x-show="error" 
        class="absolute inset-0 w-full h-full flex items-center justify-center bg-slate-100 text-slate-400 text-xs"
    >
        <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
    </div>
</div>