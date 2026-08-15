<x-guest-layout>
    <div class="mb-5 border-b border-slate-200 pb-3">
        <h1 class="text-lg font-bold text-slate-900">Buat Akun Baru</h1>
        <p class="text-xs text-slate-500 mt-0.5">Daftarkan akun pengguna baru ke dalam sistem SIA Shuka.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap</label>
            <input 
                id="name" 
                class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 text-slate-900" 
                type="text" 
                name="name" 
                value="{{ old('name') }}" 
                required 
                autofocus 
                autocomplete="name" 
                placeholder="Nama Anda"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs text-rose-600" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email</label>
            <input 
                id="email" 
                class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 text-slate-900" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autocomplete="username" 
                placeholder="nama@shuka.test"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-rose-600" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi (Password)</label>
            <input 
                id="password" 
                class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 text-slate-900" 
                type="password" 
                name="password" 
                required 
                autocomplete="new-password" 
                placeholder="Minimal 8 karakter"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-rose-600" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Kata Sandi</label>
            <input 
                id="password_confirmation" 
                class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 text-slate-900" 
                type="password" 
                name="password_confirmation" 
                required 
                autocomplete="new-password" 
                placeholder="Ulangi kata sandi"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs text-rose-600" />
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between gap-3 pt-2 text-xs">
            <a class="text-slate-600 hover:text-pink-600 hover:underline" href="{{ route('login') }}">
                Sudah punya akun? Masuk
            </a>
            <button type="submit" class="py-2.5 px-4 bg-pink-500 hover:bg-pink-600 text-white font-bold text-xs rounded transition-colors shadow-sm">
                Daftar Akun
            </button>
        </div>
    </form>
</x-guest-layout>
