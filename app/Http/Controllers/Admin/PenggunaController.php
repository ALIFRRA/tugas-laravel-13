<?php
/**
     * Murid.
     *
     * @return public murid
     */

    /**
     * Guru.
     *
     * @return public guru
     */


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenggunaController extends Controller
{
    public function guru(Request $request): View
    {
        $users = User::query()
            ->where('role', User::ROLE_GURU)
            ->with(['guru.mataPelajarans'])
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.pengguna.guru', compact('users'));
    }

    public function murid(Request $request): View
    {
        $users = User::query()
            ->where('role', User::ROLE_MURID)
            ->with('siswa')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.pengguna.murid', compact('users'));
    }
}
