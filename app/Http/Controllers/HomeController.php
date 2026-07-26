<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'siswaCount' => Siswa::count(),
            'guruCount' => Guru::count(),
            'mapelCount' => MataPelajaran::count(),
            'jadwalCount' => Jadwal::count(),
        ]);
    }
}
