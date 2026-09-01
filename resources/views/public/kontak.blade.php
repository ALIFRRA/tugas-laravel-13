<?php
@extends('layouts.public')

@section('title', 'Kontak & Akses Sekolah — SMK Shuka')
@section('page_header', true)
@section('page_heading', 'Kontak & Akses Sekolah')
@section('page_subheading', '秀華高等専門学校 • Alamat, Transportasi & Portal Akademik')
@section('page_description', 'Informasi alamat sekolah, rute transportasi kereta, kontak resmi tata usaha, dan akses portal akademik.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 space-y-8">

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        
        <!-- kolom kiri: informasi alamat dan akses transportasi -->
        <div class="md:col-span-8 space-y-6">
            
            <section class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-200">
                    <span class="w-2.5 h-6 bg-pink-500 rounded-sm"></span>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900">Alamat & Lokasi Sekolah</h2>
                </div>

                <div class="space-y-2 text-xs sm:text-sm text-slate-700 leading-relaxed">
                    <p><strong>Nama Sekolah:</strong> SMK Shuka (秀華高等専門学校)</p>
                    <p><strong>Alamat Sekolah:</strong> 〒155-0031 東京都世田谷区北沢 (Kitazawa, Setagaya-ku, Tokyo 155-0031)</p>
                    <p><strong>Lokasi Strategis:</strong> Kawasan Livehouse Musik Indie Shimokitazawa (STARRY Partnership Center)</p>
                    <p><strong>Nomor Telepon:</strong> (03) 3468-SHUKA (Representatif Tata Usaha)</p>
                    <p><strong>Email Resmi:</strong> info@smk-shuka.sch.id / admissions@shuka.test</p>
                </div>
            </section>

            <section class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-200">
                    <span class="w-2.5 h-6 bg-sky-600 rounded-sm"></span>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900">Akses Transportasi Kereta</h2>
                </div>

                <div class="space-y-3 text-xs text-slate-600 leading-relaxed">
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded space-y-1">
                        <span class="font-bold text-slate-900 text-xs">Jalur Odakyu Odawara</span>
                        <p>Turun di <strong>Stasiun Shimokitazawa</strong>, keluar melalui Gerbang Timur, berjalan kaki sekitar 4 menit menuju area Livehouse STARRY & Gedung SMK Shuka.</p>
                    </div>

                    <div class="p-3 bg-slate-50 border border-slate-200 rounded space-y-1">
                        <span class="font-bold text-slate-900 text-xs">Jalur Keio Inokashira</span>
                        <p>Turun di <strong>Stasiun Shimokitazawa</strong>, keluar melalui Gerbang Tengah, berjalan kaki sekitar 3 menit.</p>
                    </div>
                </div>
            </section>

        </div>

        <!-- Kolom Kanan: Jam Layanan & Portal (4 Col) -->
        <div class="md:col-span-4 space-y-6">
            
            <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm space-y-3 text-xs">
                <h3 class="font-bold text-slate-900 text-xs uppercase tracking-wider pb-2 border-b border-slate-200">
                    Jam Kerja Tata Usaha
                </h3>
                <div class="space-y-1.5 text-[11px] text-slate-600">
                    <div><strong>Senin - Jumat:</strong> 08:30 - 17:00</div>
                    <div><strong>Sabtu:</strong> 08:30 - 13:00</div>
                    <div><strong>Minggu & Hari Libur:</strong> Tutup</div>
                </div>
            </div>

            <div class="bg-slate-900 text-white border border-slate-800 rounded-lg p-5 shadow-sm space-y-3 text-xs">
                <h3 class="font-bold text-pink-400 text-xs uppercase tracking-wider pb-2 border-b border-slate-800">
                    Akses Portal SIA
                </h3>
                <p class="text-slate-300 text-[11px] leading-relaxed">
                    Siswa dan guru terdaftar dapat mengakses akun Sistem Informasi Akademik untuk melihat nilai rapor, jadwal kelas, dan pengumuman.
                </p>
                <a href="{{ route('login') }}" class="block text-center py-2 bg-pink-500 hover:bg-pink-600 text-white font-bold rounded transition-colors text-xs">
                    Masuk Portal SIA →
                </a>
            </div>

        </div>

    </div>

</div>
@endsection