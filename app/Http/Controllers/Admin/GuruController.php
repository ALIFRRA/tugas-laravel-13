<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGuruRequest;
use App\Http\Requests\Admin\UpdateGuruRequest;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuruController extends Controller
{
    public function index(Request $request): View
    {
        $query = Guru::query()->with('user');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('mata_pelajaran', 'like', "%{$search}%");
            });
        }

        $gurus = $query->orderBy('nip')->paginate(15)->withQueryString();

        return view('admin.guru.index', compact('gurus'));
    }

    public function create(): View
    {
        return view('admin.guru.create');
    }

    public function store(StoreGuruRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $userId = null;
        if (!empty($validated['email'])) {
            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'] ?? 'password123'),
                'role' => User::ROLE_GURU,
            ]);
            $userId = $user->id;
        }

        Guru::create([
            'user_id' => $userId,
            'nama' => $validated['nama'],
            'nip' => $validated['nip'],
            'mata_pelajaran' => $validated['mata_pelajaran'],
            'no_telepon' => $validated['no_telepon'],
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function show(Guru $guru): View
    {
        $guru->load('user', 'mataPelajarans');

        return view('admin.guru.show', compact('guru'));
    }

    public function edit(Guru $guru): View
    {
        $guru->load('user');

        return view('admin.guru.edit', compact('guru'));
    }

    public function update(UpdateGuruRequest $request, Guru $guru): RedirectResponse
    {
        $validated = $request->validated();

        if (!empty($validated['email'])) {
            if ($guru->user) {
                $userData = [
                    'name' => $validated['nama'],
                    'email' => $validated['email'],
                ];
                if (!empty($validated['password'])) {
                    $userData['password'] = Hash::make($validated['password']);
                }
                $guru->user->update($userData);
            } else {
                $user = User::create([
                    'name' => $validated['nama'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password'] ?? 'password123'),
                    'role' => User::ROLE_GURU,
                ]);
                $guru->user_id = $user->id;
            }
        }

        $guru->update([
            'user_id' => $guru->user_id,
            'nama' => $validated['nama'],
            'nip' => $validated['nip'],
            'mata_pelajaran' => $validated['mata_pelajaran'],
            'no_telepon' => $validated['no_telepon'],
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru): RedirectResponse
    {
        if ($guru->user) {
            $guru->user->delete();
        }
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
