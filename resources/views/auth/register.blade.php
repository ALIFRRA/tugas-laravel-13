<x-guest-layout>
    <h1 class="mb-6 font-display text-3xl text-shuka-pink">Daftar</h1>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="Nama" />
            <x-text-input id="name" class="mt-1 block w-full border-shuka-line focus:border-shuka-pink focus:ring-shuka-pink" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="mt-1 block w-full border-shuka-line focus:border-shuka-pink focus:ring-shuka-pink" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="mt-1 block w-full border-shuka-line focus:border-shuka-pink focus:ring-shuka-pink" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi password" />
            <x-text-input id="password_confirmation" class="mt-1 block w-full border-shuka-line focus:border-shuka-pink focus:ring-shuka-pink" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-3 pt-2">
            <a class="text-sm text-slate-500 hover:text-shuka-pink" href="{{ route('login') }}">Sudah punya akun?</a>
            <x-primary-button>Daftar</x-primary-button>
        </div>
    </form>
</x-guest-layout>
