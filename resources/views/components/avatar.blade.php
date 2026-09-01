<?php
@props([
    'user' => null,
    'size' => 'md',
    'name' => null,
    'email' => null,
    'avatar' => null,
    'class' => ''
])

@php
    // Fallback to Auth::user() ONLY if no user, name, email, or avatar was explicitly specified
    if ($user === null && $name === null && $email === null && $avatar === null) {
        $user = Auth::user();
    }
    $avatarService = app(\App\Services\AvatarService::class);

    // Resolve avatar data
    $resolvedName = $name ?? $user?->name;
    $resolvedEmail = $email ?? $user?->email;
    $resolvedAvatar = $avatar ?? $user?->avatar;

    $avatarUrl = $avatarService->getAvatarUrl($resolvedName, $resolvedEmail, $resolvedAvatar);

    $parts = preg_split('/\s+/', trim($resolvedName ?? '')) ?: [];
    $initials = collect($parts)
        ->filter()
        ->take(2)
        ->map(fn (string $part) => mb_strtoupper(mb_substr($part, 0, 1)))
        ->implode('');
    if ($initials === '') {
        $initials = 'SH';
    }

    $sizes = [
        'xs' => 'h-6 w-6 text-[10px]',
        'sm' => 'h-8 w-8 text-xs',
        'md' => 'h-10 w-10 text-sm',
        'lg' => 'h-16 w-16 text-xl',
        'xl' => 'h-24 w-24 text-3xl',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div class="relative inline-flex items-center justify-center shrink-0 rounded-full overflow-hidden border border-pink-200 bg-pink-50 shadow-sm {{ $sizeClass }} {{ $class }}">
    <img
        src="{{ $avatarUrl }}"
        alt="{{ $resolvedName ?? 'Avatar' }}"
        class="w-full h-full object-cover rounded-full"
        loading="lazy"
        decoding="async"
        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
    >
    <div class="hidden w-full h-full rounded-full items-center justify-center font-bold text-pink-700 bg-pink-100 uppercase">
        {{ $initials }}
    </div>
</div>
