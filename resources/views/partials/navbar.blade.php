<div class="flex items-center gap-3">
    <a href="{{ route('profile.show', Auth::id() ?? 1) }}" class="flex items-center gap-2.5 p-1 rounded hover:bg-slate-50 transition-colors">
        <div class="w-8 h-8 rounded bg-pink-100 text-pink-700 flex items-center justify-center font-bold text-xs border border-pink-300 overflow-hidden shrink-0">
            <img src="{{ Auth::user()?->avatarUrl() ?? asset('images/bocchi.png') }}" alt="User" class="w-full h-full object-cover">
        </div>
        <div class="hidden sm:flex flex-col text-left">
            <span class="text-xs font-bold text-slate-800 leading-tight">{{ Auth::user()->name ?? 'Administrator' }}</span>
            <span class="text-[10px] font-semibold text-pink-600">{{ Auth::user()?->roleLabel() ?? 'Admin' }}</span>
        </div>
    </a>
</div>
