<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGuruRequest;
use App\Http\Requests\Admin\UpdateGuruRequest;
use App\Models\Guru;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GuruController extends Controller
{
    public function index(): View
    {
        $gurus = Guru::query()->latest()->paginate(10);

        return view('admin.guru.index', compact('gurus'));
    }

    public function create(): View
    {
        return view('admin.guru.create');
    }

    public function store(StoreGuruRequest $request): RedirectResponse
    {
        Guru::create($request->validated());

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function show(Guru $guru): View
    {
        return view('admin.guru.show', compact('guru'));
    }

    public function edit(Guru $guru): View
    {
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(UpdateGuruRequest $request, Guru $guru): RedirectResponse
    {
        $guru->update($request->validated());

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru): RedirectResponse
    {
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
