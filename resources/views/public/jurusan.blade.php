@extends('layouts.public')

@section('title', 'Program Keahlian — SMK Shuka')
@section('page_header', true)
@section('page_heading', 'Program Keahlian Kejuruan')
@section('page_subheading', '秀華高等専門学校 • 5 Program Keahlian Berbasis Kompetensi')
@section('page_description', 'Kurikulum kejuruan berbasis kompetensi industri seni musik, tata suara panggung, desain visual, rekayasa software, dan manajemen pertunjukan.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 space-y-10">

    <!-- 1. JURUSAN 01: SENI MUSIK POPULER (SMP) -->
    <section id="smp" class="bg-white border border-slate-200 rounded-lg p-6 sm:p-8 shadow-sm border-l-4 border-l-pink-500 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-3 border-b border-slate-200">
            <div>
                <span class="text-[10px] font-bold text-pink-600 uppercase tracking-wider">Jurusan 01</span>
                <h2 class="text-lg sm:text-xl font-bold text-slate-900">Seni Musik Populer & Band (SMP)</h2>
            </div>
            <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded bg-pink-50 text-pink-700 border border-pink-200 self-start sm:self-auto">
                Rombel: X-SMP-1, X-SMP-2, XI-SMP-1, XI-SMP-2, XII-SMP-1, XII-SMP-2
            </span>
        </div>

        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
            Program keahlian yang berfokus pada penguasaan instrumen musik modern (gitar elektrik, bass, drum, keyboard, dan olah vokal), teknik aransemen lagu ensembel, penciptaan lirik lagu, serta kesiapan mental perform panggung festival musik live.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs pt-2">
            <div class="p-3 bg-slate-50 border border-slate-200 rounded space-y-1">
                <span class="font-bold text-slate-900 block text-[11px]">Kompetensi Pokok:</span>
                <ul class="text-slate-600 space-y-1 list-disc list-inside">
                    <li>Teknik Instrumen Gitar, Bass, Drum, dan Vokal Tingkat Mahir</li>
                    <li>Harmoni Musik Populer & Teori Akor Lanjutan</li>
                    <li>Praktik Ensembel Band Panggung Live di Studio STARRY</li>
                    <li>Sight Reading Partitur & Solfeggio Melodi</li>
                </ul>
            </div>

            <div class="p-3 bg-slate-50 border border-slate-200 rounded space-y-1">
                <span class="font-bold text-slate-900 block text-[11px]">Peluang Karier Lulusan:</span>
                <ul class="text-slate-600 space-y-1 list-disc list-inside">
                    <li>Musisi Band Profesional & Recording Artist</li>
                    <li>Session Player / Musisi Pengiring Konser Live</li>
                    <li>Songwriter & Music Arranger</li>
                    <li>Instruktur / Pengajar Musik Independen</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- 2. JURUSAN 02: AUDIO ENGINEERING & SOUND (AET) -->
    <section id="aet" class="bg-white border border-slate-200 rounded-lg p-6 sm:p-8 shadow-sm border-l-4 border-l-sky-600 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-3 border-b border-slate-200">
            <div>
                <span class="text-[10px] font-bold text-sky-700 uppercase tracking-wider">Jurusan 02</span>
                <h2 class="text-lg sm:text-xl font-bold text-slate-900">Audio Engineering & Tata Suara (AET)</h2>
            </div>
            <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded bg-sky-50 text-sky-700 border border-sky-200 self-start sm:self-auto">
                Rombel: X-AET-1, XI-AET-1, XII-AET-1
            </span>
        </div>

        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
            Membina teknisi dan sound engineer andal dalam mengoperasikan digital mixing console panggung konser, tata letak mikrofon akustik instrumen (microphone placement), recording studio multitrack, serta mastering rekaman digital.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs pt-2">
            <div class="p-3 bg-slate-50 border border-slate-200 rounded space-y-1">
                <span class="font-bold text-slate-900 block text-[11px]">Kompetensi Pokok:</span>
                <ul class="text-slate-600 space-y-1 list-disc list-inside">
                    <li>Pengoperasian Konsol Soundboard Digital & Analog</li>
                    <li>Akustik Ruang & Sound Reinforcement Konser</li>
                    <li>Recording Studio dengan Digital Audio Workstation (DAW)</li>
                    <li>Audio Mixing & Mastering Standar Industri Streaming</li>
                </ul>
            </div>

            <div class="p-3 bg-slate-50 border border-slate-200 rounded space-y-1">
                <span class="font-bold text-slate-900 block text-[11px]">Peluang Karier Lulusan:</span>
                <ul class="text-slate-600 space-y-1 list-disc list-inside">
                    <li>Front of House (FOH) Sound Engineer Konser Live</li>
                    <li>Studio Recording & Mixing Engineer</li>
                    <li>Audio Broadcast & Live Streaming Technician</li>
                    <li>Acoustic Consultant Studio & Venue</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- 3. JURUSAN 03: DESAIN KOMUNIKASI VISUAL (DKV) -->
    <section id="dkv" class="bg-white border border-slate-200 rounded-lg p-6 sm:p-8 shadow-sm border-l-4 border-l-amber-500 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-3 border-b border-slate-200">
            <div>
                <span class="text-[10px] font-bold text-amber-700 uppercase tracking-wider">Jurusan 03</span>
                <h2 class="text-lg sm:text-xl font-bold text-slate-900">Desain Komunikasi Visual & Merchandise (DKV)</h2>
            </div>
            <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded bg-amber-50 text-amber-700 border border-amber-200 self-start sm:self-auto">
                Rombel: X-DKV-1, XI-DKV-1, XII-DKV-1
            </span>
        </div>

        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
            Menghasilkan desainer grafis dan kreator visual yang kompeten dalam merancang merchandise resmi band (kaos, stiker, pin), cover album piringan hitam/CD, poster festival promosi, serta fotografi panggung konser musik.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs pt-2">
            <div class="p-3 bg-slate-50 border border-slate-200 rounded space-y-1">
                <span class="font-bold text-slate-900 block text-[11px]">Kompetensi Pokok:</span>
                <ul class="text-slate-600 space-y-1 list-disc list-inside">
                    <li>Desain Grafis Vektor & Ilustrasi Digital Karakter</li>
                    <li>Produksi Sablon Screen Printing & Cetak Merchandise</li>
                    <li>Fotografi Low-Light Panggung Konser Musik</li>
                    <li>Tipografi & Tata Letak Cover Album Musik</li>
                </ul>
            </div>

            <div class="p-3 bg-slate-50 border border-slate-200 rounded space-y-1">
                <span class="font-bold text-slate-900 block text-[11px]">Peluang Karier Lulusan:</span>
                <ul class="text-slate-600 space-y-1 list-disc list-inside">
                    <li>Merchandise Designer & Brand Creative Director</li>
                    <li>Album Cover & Poster Visual Artist</li>
                    <li>Fotografer Panggung & Jurnalis Musik</li>
                    <li>Motion Graphic & UI/UX Multimedia Designer</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- 4. JURUSAN 04: REKAYASA PERANGKAT LUNAK (RPL) -->
    <section id="rpl" class="bg-white border border-slate-200 rounded-lg p-6 sm:p-8 shadow-sm border-l-4 border-l-indigo-600 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-3 border-b border-slate-200">
            <div>
                <span class="text-[10px] font-bold text-indigo-700 uppercase tracking-wider">Jurusan 04</span>
                <h2 class="text-lg sm:text-xl font-bold text-slate-900">Rekayasa Perangkat Lunak & Multimedia (RPL)</h2>
            </div>
            <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded bg-indigo-50 text-indigo-700 border border-indigo-200 self-start sm:self-auto">
                Rombel: X-RPL-1, XI-RPL-1, XII-RPL-1
            </span>
        </div>

        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
            Mencetak programmer dan software engineer handal dalam pengembangan aplikasi web portal sistem informasi akademik, database audio digital, aplikasi synthesizer berbasis Web Audio API, dan integrasi cloud.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs pt-2">
            <div class="p-3 bg-slate-50 border border-slate-200 rounded space-y-1">
                <span class="font-bold text-slate-900 block text-[11px]">Kompetensi Pokok:</span>
                <ul class="text-slate-600 space-y-1 list-disc list-inside">
                    <li>Pemrograman Web Modern (PHP/Laravel, JavaScript, Tailwind)</li>
                    <li>Manajemen Basis Data Relasional (MySQL / PostgreSQL)</li>
                    <li>Pemrograman Web Audio API & DSP Efek Suara</li>
                    <li>Keamanan Sistem Informasi & Manajemen Server Linux</li>
                </ul>
            </div>

            <div class="p-3 bg-slate-50 border border-slate-200 rounded space-y-1">
                <span class="font-bold text-slate-900 block text-[11px]">Peluang Karier Lulusan:</span>
                <ul class="text-slate-600 space-y-1 list-disc list-inside">
                    <li>Fullstack Web Developer & Software Engineer</li>
                    <li>Audio Plugin & DSP Software Developer</li>
                    <li>Database Administrator & DevOps Engineer</li>
                    <li>Interactive Multimedia Developer</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- 5. JURUSAN 05: MANAJEMEN BISNIS PERTUNJUKAN (MBE) -->
    <section id="mbe" class="bg-white border border-slate-200 rounded-lg p-6 sm:p-8 shadow-sm border-l-4 border-l-emerald-600 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-3 border-b border-slate-200">
            <div>
                <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">Jurusan 05</span>
                <h2 class="text-lg sm:text-xl font-bold text-slate-900">Manajemen Bisnis Pertunjukan & Live Event (MBE)</h2>
            </div>
            <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded bg-emerald-50 text-emerald-700 border border-emerald-200 self-start sm:self-auto">
                Rombel: X-MBE-1, XI-MBE-1, XII-MBE-1
            </span>
        </div>

        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
            Mempersiapkan manajer dan produser pertunjukan profesional dalam mengelola operasional konser musik live, promosi media sosial, ticketing festival, manajemen talent musisi, serta hospitality livehouse cafe STARRY.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs pt-2">
            <div class="p-3 bg-slate-50 border border-slate-200 rounded space-y-1">
                <span class="font-bold text-slate-900 block text-[11px]">Kompetensi Pokok:</span>
                <ul class="text-slate-600 space-y-1 list-disc list-inside">
                    <li>Manajemen Operasional Konser Live & Festival Shuka-sai</li>
                    <li>Digital Marketing & Promosi Media Kreatif Band</li>
                    <li>Tata Kelola Hak Cipta & Lisensi Musik</li>
                    <li>Hospitality & Manajemen Layanan F&B Livehouse Cafe</li>
                </ul>
            </div>

            <div class="p-3 bg-slate-50 border border-slate-200 rounded space-y-1">
                <span class="font-bold text-slate-900 block text-[11px]">Peluang Karier Lulusan:</span>
                <ul class="text-slate-600 space-y-1 list-disc list-inside">
                    <li>Live Event & Concert Organizer Manager</li>
                    <li>Livehouse Stage & Venue Manager</li>
                    <li>Artist & Band Talent Manager</li>
                    <li>Music Label Promotion & PR Specialist</li>
                </ul>
            </div>
        </div>
    </section>

</div>
@endsection