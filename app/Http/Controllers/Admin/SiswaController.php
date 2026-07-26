<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSiswaRequest;
use App\Http\Requests\Admin\UpdateSiswaRequest;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiswaController extends Controller
{
    public function index(): View
    {
        $siswas = Siswa::query()->latest()->paginate(10);

        return view('admin.siswa.index', compact('siswas'));
    }

    public function create(): View
    {
        return view('admin.siswa.create');
    }

    public function store(StoreSiswaRequest $request): RedirectResponse
    {
        Siswa::create($request->validated());

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(Siswa $siswa): View
    {
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa): View
    {
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(UpdateSiswaRequest $request, Siswa $siswa): RedirectResponse
    {
        $siswa->update($request->validated());

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa): RedirectResponse
    {
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
