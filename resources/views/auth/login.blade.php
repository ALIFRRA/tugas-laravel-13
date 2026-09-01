<?php
<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Masuk ke Akun Portal</h1>
        <p class="text-xs text-slate-500 mt-1">Masukkan kredensial akun Anda untuk mengakses sistem akademik SMK Shuka.</p>
    </div>

    <!-- Quick Role Switcher Chips (Mobile & Form Level) -->
    <div class="mb-5 p-3 bg-slate-50 border border-slate-200 rounded-lg">
        <span class="text-[11px] font-semibold text-slate-600 block mb-2">Autofill Role Cepat:</span>
        <div class="flex flex-wrap gap-1.5">
            <button type="button" onclick="fillLogin('admin@shuka.test', 'password')" class="px-2.5 py-1 text-[11px] font-semibold rounded bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 transition-colors shadow-2xs">
                Admin
            </button>
            <button type="button" onclick="fillLogin('seika@shuka.test', 'password')" class="px-2.5 py-1 text-[11px] font-semibold rounded bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 transition-colors shadow-2xs">
                Kepsek
            </button>
            <button type="button" onclick="fillLogin('tu@shuka.test', 'password')" class="px-2.5 py-1 text-[11px] font-semibold rounded bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 transition-colors shadow-2xs">
                Tata Usaha
            </button>
            <button type="button" onclick="fillLogin('guru10@shuka.test', 'password')" class="px-2.5 py-1 text-[11px] font-semibold rounded bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 transition-colors shadow-2xs">
                Guru
            </button>
            <button type="button" onclick="fillLogin('student1@murid.shuka.test', 'password')" class="px-2.5 py-1 text-[11px] font-semibold rounded bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 transition-colors shadow-2xs">
                Siswa
            </button>
        </div>
    </div>

    <x-auth-session-status class="mb-4 text-xs font-semibold text-emerald-700 bg-emerald-50 p-2.5 rounded border border-emerald-200" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email</label>
            <input 
                id="email" 
                class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2.5 px-3 text-slate-900 transition-colors shadow-2xs" 
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
                class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2.5 px-3 text-slate-900 transition-colors shadow-2xs" 
                type="password" 
                name="password" 
                value="password"
                required 
                autocomplete="current-password" 
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-rose-600" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between text-xs pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-pink-600 focus:ring-pink-500" name="remember">
                <span class="ms-2 text-slate-600">Ingat sesi saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-pink-600 hover:text-pink-700 font-medium transition-colors" href="{{ route('password.request') }}">
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-3">
            <button type="submit" class="w-full py-2.5 px-4 bg-pink-500 hover:bg-pink-600 text-white font-bold text-xs rounded transition-colors shadow-sm text-center">
                Masuk ke Sistem SIA
            </button>
        </div>
    </form>

    <div class="mt-8 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
        <span>Belum memiliki akun?</span>
        <a href="{{ route('register') }}" class="font-bold text-pink-600 hover:text-pink-700 hover:underline">
            Daftar Akun Baru →
        </a>
    </div>
</x-guest-layout>
