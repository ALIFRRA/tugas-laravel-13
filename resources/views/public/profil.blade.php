<?php
@extends('layouts.public')

@section('title', 'Profil Sekolah — SMK Shuka')
@section('page_header', true)
@section('page_heading', 'Profil Sekolah')
@section('page_subheading', '秀華高等専門学校 • Profil, Visi-Misi & Fasilitas')
@section('page_description', 'Informasi resmi mengenai sejarah, visi-misi, sambutan pimpinan, dan fasilitas kejuruan SMK Shuka.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 space-y-10">

    <!-- 1. SAMBUTAN PIMPINAN SEKOLAH -->
    <section class="bg-white border border-slate-200 rounded-lg p-6 sm:p-8 shadow-sm space-y-5">
        <div class="flex items-center gap-3 pb-4 border-b border-slate-200">
            <span class="w-2.5 h-6 bg-pink-500 rounded-sm"></span>
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-slate-900">Sambutan Pimpinan Sekolah</h2>
                <p class="text-xs text-slate-500">Membina Generasi Unggul di Industri Kreatif & Musik</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
            <div class="md:col-span-8 space-y-3.5 text-xs sm:text-sm text-slate-700 leading-relaxed">
                <p>
                    Selamat datang di portal resmi <strong>SMK Shuka (秀華高等専門学校)</strong>. Sebagai lembaga pendidikan kejuruan yang berakar di episentrum musik independen Shimokitazawa, kami mendedikasikan diri untuk melahirkan praktisi andal, musisi berkarakter, teknisi tata suara panggung, desainer visual, dan tenaga pengembang teknologi kreatif.
                </p>
                <p>
                    Kurikulum SMK Shuka dirancang secara sinergis bersama mitra industri dan livehouse terkemuka. Siswa tidak hanya mempelajari teori di dalam kelas, melainkan langsung terjun ke panggung pertunjukan konser nyata, mengoperasikan peralatan soundboard mutakhir, dan mengelola event profesional.
                </p>
                <p>
                    Kami percaya bahwa perpaduan antara disiplin latihan keras, kepekaan harmoni rasa, dan penguasaan teknologi digital akan menjadi bekal utama bagi setiap lulusan dalam menembus panggung profesional nasional maupun internasional.
                </p>
                <div class="pt-3 border-t border-slate-100">
                    <span class="font-bold text-slate-900 block text-xs">Seika Ijichi, S.Sn., M.Pd.</span>
                    <span class="text-[11px] text-slate-500">Pimpinan Program Industri & Pembina Kejuruan Musik Shuka</span>
                </div>
            </div>

            <div class="md:col-span-4 bg-slate-50 border border-slate-200 rounded-lg p-4 space-y-3 text-xs">
                <div class="font-bold text-slate-900 pb-2 border-b border-slate-200 text-xs">
                    Identitas Institusi
                </div>
                <div class="space-y-2 text-[11px] text-slate-600">
                    <div><strong>Nama Resmi:</strong> SMK Shuka (秀華高等専門学校)</div>
                    <div><strong>Status:</strong> Sekolah Menengah Kejuruan Swasta Terakreditasi A</div>
                    <div><strong>Lokasi Sekolah:</strong> Shimokitazawa, Setagaya-ku, Tokyo</div>
                    <div><strong>Mitra Industri:</strong> Livehouse STARRY & Tokyo Sound Lab</div>
                    <div><strong>Total Siswa:</strong> 600 Murid (18 Rombel)</div>
                    <div><strong>Tenaga Pendidik:</strong> 45 Guru Bersertifikasi</div>
                </div>
            </div>
        </div>
    </section>

    <!-- visi dan misi sekolah -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm space-y-3">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200">
                <span class="w-2 h-2 bg-pink-500 rounded-full"></span>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Visi Sekolah</h3>
            </div>
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                "Menjadi pusat keunggulan pendidikan kejuruan seni pertunjukan musik populer, tata suara panggung, dan multimedia kreatif berstandar industri internasional yang berakar pada integritas moral dan kerja tim."
            </p>
        </div>

        <div class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm space-y-3">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200">
                <span class="w-2 h-2 bg-sky-600 rounded-full"></span>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Misi Sekolah</h3>
            </div>
            <ul class="text-xs text-slate-600 space-y-2 list-disc list-inside leading-relaxed">
                <li>Menyelenggarakan pembelajaran berbasis proyek (Project-Based Learning) panggung konser.</li>
                <li>Membekali siswa dengan sertifikasi kompetensi audio engineering & multimedia resmi.</li>
                <li>Membangun kerja sama magang industri dengan studio rekaman dan label musik independen.</li>
                <li>Membentuk karakter disiplin, daya juang tinggi, dan etika profesional di dunia kerja.</li>
            </ul>
        </div>

    </section>

    <!-- fasilitas dan laboratorium sekolah -->
    <section class="bg-white border border-slate-200 rounded-lg p-6 sm:p-8 shadow-sm space-y-5">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
            <div>
                <h2 class="text-base sm:text-lg font-bold text-slate-900">Fasilitas Laboratorium & Studio</h2>
                <p class="text-xs text-slate-500">Peralatan standar panggung dan studio rekaman industri.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
            
            <div class="p-4 bg-slate-50 border border-slate-200 rounded space-y-2">
                <span class="text-[10px] font-bold text-pink-600 uppercase">Studio 01</span>
                <h4 class="font-bold text-slate-900">Livehouse STARRY Basement Stage</h4>
                <p class="text-slate-600 leading-relaxed">Panggung konser akustik dengan kapasitas 250 penonton untuk gladi resik pertunjukan live ensembel band.</p>
            </div>

            <div class="p-4 bg-slate-50 border border-slate-200 rounded space-y-2">
                <span class="text-[10px] font-bold text-sky-700 uppercase">Studio 02</span>
                <h4 class="font-bold text-slate-900">Audio Engineering & DAW Lab</h4>
                <p class="text-slate-600 leading-relaxed">Lab konsol mixer digital 32-channel, workstation ProTools/Logic Pro, microphone locker, dan sound acoustic booth.</p>
            </div>

            <div class="p-4 bg-slate-50 border border-slate-200 rounded space-y-2">
                <span class="text-[10px] font-bold text-amber-700 uppercase">Studio 03</span>
                <h4 class="font-bold text-slate-900">DKV Graphic & Screen Printing Studio</h4>
                <p class="text-slate-600 leading-relaxed">Studio sablon merchandise, printer format besar, drawing tablet, dan lab fotografi panggung berkecepatan tinggi.</p>
            </div>

            <div class="p-4 bg-slate-50 border border-slate-200 rounded space-y-2">
                <span class="text-[10px] font-bold text-indigo-700 uppercase">Studio 04</span>
                <h4 class="font-bold text-slate-900">Software & Web Multimedia Center</h4>
                <p class="text-slate-600 leading-relaxed">Lab komputer terhubung jaringan gigabit fiber untuk pemrograman web portal, synthesizer DSP, dan animasi video.</p>
            </div>

            <div class="p-4 bg-slate-50 border border-slate-200 rounded space-y-2">
                <span class="text-[10px] font-bold text-emerald-700 uppercase">Studio 05</span>
                <h4 class="font-bold text-slate-900">Livehouse Cafe & Hospitality Kitchen</h4>
                <p class="text-slate-600 leading-relaxed">Dapur barista dan hospitality management untuk pelatihan operasional food & beverage festival livehouse.</p>
            </div>

            <div class="p-4 bg-slate-50 border border-slate-200 rounded space-y-2">
                <span class="text-[10px] font-bold text-slate-700 uppercase">Fasilitas 06</span>
                <h4 class="font-bold text-slate-900">Auditorium & Gymnasium Shuka</h4>
                <p class="text-slate-600 leading-relaxed">Aula serbaguna berkapasitas 1.000 orang dilengkapi sistem tata cahaya panggung DMX512 dan tata suara gantung.</p>
            </div>

        </div>
    </section>

</div>
@endsection