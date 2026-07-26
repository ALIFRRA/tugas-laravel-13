<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMapelRequest;
use App\Http\Requests\Admin\UpdateMapelRequest;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MapelController extends Controller
{
    public function index(): View
    {
        $mapels = MataPelajaran::with('guru')->latest()->paginate(10);

        return view('admin.mapel.index', compact('mapels'));
    }

    public function create(): View
    {
        $gurus = Guru::orderBy('nama')->get();

        return view('admin.mapel.create', compact('gurus'));
    }

    public function store(StoreMapelRequest $request): RedirectResponse
    {
        MataPelajaran::create($request->validated());

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function show(MataPelajaran $mapel): View
    {
        $mapel->load('guru');

        return view('admin.mapel.show', compact('mapel'));
    }

    public function edit(MataPelajaran $mapel): View
    {
        $gurus = Guru::orderBy('nama')->get();

        return view('admin.mapel.edit', compact('mapel', 'gurus'));
    }

    public function update(UpdateMapelRequest $request, MataPelajaran $mapel): RedirectResponse
    {
        $mapel->update($request->validated());

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mapel): RedirectResponse
    {
        $mapel->delete();

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
