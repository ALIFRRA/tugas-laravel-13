<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h1 class="mb-6 font-display text-3xl text-shuka-pink">Login</h1>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="mt-1 block w-full border-shuka-line focus:border-shuka-pink focus:ring-shuka-pink" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="mt-1 block w-full border-shuka-line focus:border-shuka-pink focus:ring-shuka-pink" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-shuka-pink focus:ring-shuka-pink" name="remember">
                <span class="ms-2 text-sm text-slate-600">Ingat saya</span>
            </label>
        </div>

        <div class="flex items-center justify-between gap-3 pt-2">
            @if (Route::has('password.request'))
                <a class="text-sm text-slate-500 hover:text-shuka-pink" href="{{ route('password.request') }}">Lupa password?</a>
            @endif
            <x-primary-button>Masuk</x-primary-button>
        </div>
    </form>
</x-guest-layout>
