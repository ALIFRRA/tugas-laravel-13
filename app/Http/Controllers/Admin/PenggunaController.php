<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class PenggunaController extends Controller
{
    public function indexGuru(): View
    {
        $users = User::query()
            ->where('role', User::ROLE_GURU)
            ->with('guru.mataPelajarans')
            ->orderBy('name')
            ->paginate(12);

        return view('admin.pengguna.guru', compact('users'));
    }

    public function indexMurid(): View
    {
        $users = User::query()
            ->where('role', User::ROLE_MURID)
            ->with(['siswa.nilais'])
            ->orderBy('name')
            ->paginate(12);

        return view('admin.pengguna.murid', compact('users'));
    }
}
