@extends('layouts.admin')

@section('title', 'Direktori Akun Guru — SMK Shuka')
@section('heading', 'Direktori Akun Guru')

@section('content')
<div class="space-y-5">
    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Manajemen Akun Guru</h1>
            <p class="text-xs text-slate-500 mt-0.5">Daftar {{ $users->total() }} akun tenaga pendidik terdaftar di sistem.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.pengguna.guru') }}" class="px-3 py-1.5 text-xs font-bold rounded bg-pink-50 text-pink-700 border border-pink-200">Akun Guru</a>
            <a href="{{ route('admin.pengguna.murid') }}" class="px-3 py-1.5 text-xs font-semibold rounded bg-white text-slate-700 border border-slate-300 hover:bg-slate-50">Akun Siswa</a>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider">
                        <th class="py-2.5 px-4 border-r border-slate-200">Avatar</th>
                        <th class="py-2.5 px-4 border-r border-slate-200">Nama Pendidik</th>
                        <th class="py-2.5 px-4 border-r border-slate-200">Alamat Email</th>
                        <th class="py-2.5 px-4 border-r border-slate-200">NIP</th>
                        <th class="py-2.5 px-4 border-r border-slate-200">Mata Pelajaran</th>
                        <th class="py-2.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($users as $user)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-2.5 px-4 border-r border-slate-100"><x-avatar :user="$user" size="sm" /></td>
                            <td class="py-2.5 px-4 font-bold text-slate-900 border-r border-slate-100">{{ $user->name }}</td>
                            <td class="py-2.5 px-4 font-mono text-slate-600 border-r border-slate-100">{{ $user->email }}</td>
                            <td class="py-2.5 px-4 font-mono text-slate-600 border-r border-slate-100">{{ $user->guru?->nip ?? '—' }}</td>
                            <td class="py-2.5 px-4 text-slate-700 border-r border-slate-100">{{ $user->guru?->mata_pelajaran ?? '—' }}</td>
                            <td class="py-2.5 px-4 text-center">
                                <a href="{{ route('profile.show', $user->id) }}" class="px-2.5 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded transition-colors">
                                    Lihat Profil
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada akun guru terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-3 bg-slate-50 border-t border-slate-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
