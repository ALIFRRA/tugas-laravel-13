@props([
    'user' => null, 
    'size' => 'md', 
    'name' => null,
    'email' => null,
    'avatar' => null,
    'class' => ''
])

@php
    $user = $user ?? Auth::user();
    $avatarService = app(\App\Services\AvatarService::class);
    
    // Resolve avatar data
    $resolvedName = $name ?? $user?->name;
    $resolvedEmail = $email ?? $user?->email;
    $resolvedAvatar = $avatar ?? $user?->avatar;
    
    $avatarData = $avatarService->getAvatarData($resolvedName, $resolvedEmail, $resolvedAvatar, $size);
    
    $sizes = [
        'xs' => 'h-6 w-6',
        'sm' => 'h-8 w-8',
        'md' => 'h-10 w-10',
        'lg' => 'h-16 w-16',
        'xl' => 'h-24 w-24',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    
    // Generate fallback SVG for error handling
    $fallbackSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50" fill="#fce7f3"/><text x="50" y="55" font-size="40" text-anchor="middle" fill="#ec4899">' . $avatarData['initials'] . '</text></svg>';
    $fallbackSrc = 'data:image/svg+xml;base64,' . base64_encode($fallbackSvg);
@endphp

<div 
    class="relative inline-block {{ $class }}"
    x-data="{ loaded: false }"
    style="width: {{ explode(' ', $sizeClass)[1] }}; height: {{ explode(' ', $sizeClass)[0] }};"
>
    <!-- Blur placeholder (loads instantly) -->
    <img
        src="{{ $avatarData['placeholder'] }}"
        alt=""
        class="absolute inset-0 w-full h-full rounded-full object-cover blur-[20px] scale-110 transition-opacity duration-500"
        :class="{ 'opacity-0': loaded, 'opacity-100': !loaded }"
        aria-hidden="true"
    >
    
    <!-- Actual avatar image (progressive load) -->
    <img
        src="{{ $avatarData['url'] }}"
        alt="{{ $avatarData['alt'] }}"
        class="absolute inset-0 w-full h-full rounded-full object-cover border border-slate-200 bg-slate-50 transition-all duration-500"
        :class="{ 'opacity-100 scale-100': loaded, 'opacity-0 scale-95': !loaded }"
        @load="loaded = true"
        onerror="this.onerror=null; this.src='{{ $fallbackSrc }}'; loaded=true;"
        loading="lazy"
        decoding="async"
    >
    
    <!-- Fallback initials (shown if both images fail) -->
    <div 
        x-show="!loaded" 
        class="absolute inset-0 w-full h-full rounded-full flex items-center justify-center font-bold text-pink-600 bg-pink-50 border border-slate-200"
        :style="{
            'font-size': {
                'xs': '0.6rem',
                'sm': '0.75rem', 
                'md': '0.875rem',
                'lg': '1.5rem',
                'xl': '2rem'
            }['{{ $size }}'] || '0.875rem'
        }"
    >
        {{ $avatarData['initials'] }}
    </div>
</div>