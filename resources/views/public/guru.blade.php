@extends('layouts.public')

@section('title', 'Tenaga Pendidik (教職員紹介) — SMK Shuka (秀華高等専門学校)')
@section('page_header', true)
@section('page_heading', 'Tenaga Pendidik & Instruktur (教職員紹介)')
@section('page_subheading_jp', '秀華高等専門学校 • 専任教員・講師陣一覧')
@section('page_description', 'Daftar 45 guru bersertifikasi dan praktisi industri seni musik populer, audio engineering, desain visual, rekayasa software, dan manajemen event.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 space-y-6">

    <!-- Filter & Pencarian Guru (検索) -->
    <div class="bg-white p-4 border border-slate-200 rounded-lg shadow-sm">
        <form method="GET" action="{{ route('public.guru') }}" class="flex flex-col sm:flex-row sm:items-center gap-3">
            <div class="flex-1 relative">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama guru, NIP, atau mata pelajaran kejuruan..." 
                    class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 pl-9 pr-3"
                >
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-slate-800 hover:bg-slate-900 rounded transition-colors">
                    Cari Guru (検索)
                </button>

                @if(request('search'))
                    <a href="{{ route('public.guru') }}" class="px-3 py-2 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Grid Guru (Minimalis & Rapi Khas Jepang) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse ($gurus as $guru)
            <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm hover:border-pink-300 transition-colors flex flex-col justify-between space-y-3">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs border border-slate-200 shrink-0">
                        {{ strtoupper(substr($guru->nama, 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-xs font-bold text-slate-900 leading-snug">{{ $guru->nama }}</h3>
                        <p class="text-[11px] font-semibold text-pink-600 mt-0.5">{{ $guru->mata_pelajaran }}</p>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[10px] text-slate-500 font-mono">
                    <span>NIP: {{ $guru->nip }}</span>
                    <span class="text-slate-400">SMK Shuka</span>
                </div>
            </div>
        @empty
            <div class="col-span-4 p-8 text-center text-xs text-slate-400 bg-white border border-slate-200 rounded-lg">
                Tidak ditemukan data tenaga pendidik dengan kata kunci yang dicari.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($gurus->hasPages())
        <div class="p-4 bg-white border border-slate-200 rounded-lg">
            {{ $gurus->links() }}
        </div>
    @endif

</div>
@endsection
