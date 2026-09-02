<div class="flex items-center gap-3">
    <!-- shortcut input nilai cepat untuk guru dan admin -->
    @if(Auth::user()?->isGuru())
        <a href="{{ route('guru.nilai.index') }}" class="px-3 py-1.5 text-xs font-bold text-white bg-pink-500 hover:bg-pink-600 rounded flex items-center gap-1.5 transition-colors shadow-2xs">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Input Nilai</span>
        </a>
    @elseif(Auth::user()?->isAdministratorLevel())
        <a href="{{ route('admin.nilai.create') }}" class="px-3 py-1.5 text-xs font-bold text-white bg-pink-500 hover:bg-pink-600 rounded flex items-center gap-1.5 transition-colors shadow-2xs">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Input Nilai</span>
        </a>
    @endif

    <!-- profil pengguna ringkas -->
    <a href="{{ route('profile.show', Auth::id() ?? 1) }}" class="flex items-center gap-2.5 p-1 rounded hover:bg-slate-50 transition-colors">
        <x-avatar :user="Auth::user()" size="sm" class="shrink-0" />
        <div class="hidden sm:flex flex-col text-left">
            <span class="text-xs font-bold text-slate-800 leading-tight">{{ Auth::user()->name ?? 'Pengguna' }}</span>
            <span class="text-[10px] font-semibold text-pink-600">{{ Auth::user()?->roleLabel() ?? 'Admin' }}</span>
        </div>
    </a>
</div>
