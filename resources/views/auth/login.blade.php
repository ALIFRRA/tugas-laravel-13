<x-guest-layout>
    <div class="mb-5 border-b border-slate-200 pb-3">
        <h1 class="text-lg font-bold text-slate-900">Masuk ke Akun Portal</h1>
        <p class="text-xs text-slate-500 mt-0.5">Gunakan email dan kata sandi yang telah terdaftar.</p>
    </div>

    <x-auth-session-status class="mb-4 text-xs font-semibold text-emerald-700 bg-emerald-50 p-2.5 rounded border border-emerald-200" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email</label>
            <input 
                id="email" 
                class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 text-slate-900" 
                type="email" 
                name="email" 
                value="{{ old('email', 'admin@shuka.test') }}" 
                required 
                autofocus 
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
                value="password"
                required 
                autocomplete="current-password" 
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-rose-600" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between text-xs">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-pink-600 focus:ring-pink-500" name="remember">
                <span class="ms-2 text-slate-600">Ingat sesi saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-pink-600 hover:text-pink-700 font-medium" href="{{ route('password.request') }}">
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-2.5 px-4 bg-pink-500 hover:bg-pink-600 text-white font-bold text-xs rounded transition-colors shadow-sm text-center">
                Masuk ke Sistem SIA
            </button>
        </div>
    </form>

    <!-- Quick Credentials Hint -->
    <div class="mt-6 pt-4 border-t border-slate-100 text-xs text-slate-500">
        <span class="font-semibold text-slate-700 block mb-1.5">Akun Demo Berdasarkan Jabatan:</span>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1 text-[11px]">
            <div>• <strong class="text-slate-700">Kepala Sekolah:</strong> <span class="font-mono text-pink-600">seika@shuka.test</span></div>
            <div>• <strong class="text-slate-700">Wakepsek (Kurikulum):</strong> <span class="font-mono text-pink-600">pasan@shuka.test</span></div>
            <div>• <strong class="text-slate-700">Kepala Tata Usaha:</strong> <span class="font-mono text-pink-600">tu@shuka.test</span></div>
            <div>• <strong class="text-slate-700">Staf TU Bagian IT:</strong> <span class="font-mono text-pink-600">it@shuka.test</span></div>
            <div>• <strong class="text-slate-700">Staf Kesiswaan:</strong> <span class="font-mono text-slate-600">kesiswaan@shuka.test</span></div>
            <div>• <strong class="text-slate-700">Guru Umum:</strong> <span class="font-mono text-slate-600">guru10@shuka.test</span></div>
            <div>• <strong class="text-slate-700">Murid (Siswa):</strong> <span class="font-mono text-slate-600">student1@murid.shuka.test</span></div>
            <div>• <strong class="text-slate-700">Super Administrator:</strong> <span class="font-mono text-pink-600">admin@shuka.test</span></div>
        </div>
        <div class="text-[10px] text-slate-400 mt-1">Semua password: <span class="font-mono text-slate-600 font-semibold">password</span></div>
    </div>
</x-guest-layout>
