<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSiswaRequest;
use App\Http\Requests\Admin\UpdateSiswaRequest;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiswaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Siswa::query()->with(['user', 'nilais']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jurusan') && $request->input('jurusan') !== 'all') {
            $jurusan = $request->input('jurusan');
            $query->where('kelas', 'like', "%-{$jurusan}-%");
        }

        if ($request->filled('tingkat') && $request->input('tingkat') !== 'all') {
            $tingkat = $request->input('tingkat');
            $query->where('kelas', 'like', "{$tingkat}-%");
        }

        if ($request->filled('kelas') && $request->input('kelas') !== 'all') {
            $query->where('kelas', $request->input('kelas'));
        }

        if ($request->filled('gender') && $request->input('gender') !== 'all') {
            $query->where('jenis_kelamin', $request->input('gender'));
        }

        $siswas = $query->orderBy('nis')->paginate(20)->withQueryString();
        $kelasList = Siswa::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

        return view('admin.siswa.index', compact('siswas', 'kelasList'));
    }

    public function create(): View
    {
        return view('admin.siswa.create');
    }

    public function store(StoreSiswaRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $userId = null;
        if (!empty($validated['email'])) {
            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'] ?? 'password123'),
                'role' => User::ROLE_MURID,
            ]);
            $userId = $user->id;
        }

        Siswa::create([
            'user_id' => $userId,
            'nama' => $validated['nama'],
            'nis' => $validated['nis'],
            'kelas' => $validated['kelas'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'alamat' => $validated['alamat'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data murid berhasil ditambahkan.');
    }

    public function show(Siswa $siswa): View
    {
        $siswa->load(['user', 'nilais.mapel', 'pelanggarans']);

        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa): View
    {
        $siswa->load('user');

        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(UpdateSiswaRequest $request, Siswa $siswa): RedirectResponse
    {
        $validated = $request->validated();

        if (!empty($validated['email'])) {
            if ($siswa->user) {
                $userData = [
                    'name' => $validated['nama'],
                    'email' => $validated['email'],
                ];
                if (!empty($validated['password'])) {
                    $userData['password'] = Hash::make($validated['password']);
                }
                $siswa->user->update($userData);
            } else {
                $user = User::create([
                    'name' => $validated['nama'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password'] ?? 'password123'),
                    'role' => User::ROLE_MURID,
                ]);
                $siswa->user_id = $user->id;
            }
        }

        $siswa->update([
            'user_id' => $siswa->user_id,
            'nama' => $validated['nama'],
            'nis' => $validated['nis'],
            'kelas' => $validated['kelas'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'alamat' => $validated['alamat'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data murid berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa): RedirectResponse
    {
        if ($siswa->user) {
            $siswa->user->delete();
        }
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Data murid berhasil dihapus.');
    }
}
