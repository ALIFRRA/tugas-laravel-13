<?php
<nav x-data="{ open: false }" class="border-b border-shuka-line bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="font-display text-2xl text-shuka-pink">Shuka Highschool</a>
                <div class="hidden sm:flex sm:gap-6">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                    <x-nav-link :href="route('admin.siswa.index')" :active="request()->routeIs('admin.*')">Admin</x-nav-link>
                </div>
            </div>

            <div class="hidden items-center gap-3 sm:flex">
                <img src="{{ asset('images/bocchi-shy.png') }}" alt="Hitori Gotou" class="bocchi-mascot h-10 w-8 object-contain">
                <a href="{{ route('profile.show', Auth::id()) }}" class="flex items-center gap-2 border border-shuka-line px-2 py-1.5 hover:border-shuka-pink">
                    <x-avatar :user="Auth::user()" size="sm" />
                    <span class="text-sm text-slate-700">{{ Auth::user()->name }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="border border-shuka-line px-3 py-1.5 text-sm text-slate-600 hover:border-shuka-pink hover:text-shuka-pink">Keluar</button>
                </form>
            </div>

            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="border border-shuka-line px-3 py-1.5 text-sm text-slate-600">Menu</button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-shuka-line sm:hidden">
        <div class="space-y-1 px-4 py-3">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.siswa.index')">Admin</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('profile.show', Auth::id())">Profil</x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Keluar</x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
