<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreJadwalRequest;
use App\Http\Requests\Admin\UpdateJadwalRequest;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JadwalController extends Controller
{
    public function index(): View
    {
        $jadwals = Jadwal::with('mapel')->latest()->paginate(10);

        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function create(): View
    {
        $mapels = MataPelajaran::orderBy('nama')->get();

        return view('admin.jadwal.create', compact('mapels'));
    }

    public function store(StoreJadwalRequest $request): RedirectResponse
    {
        Jadwal::create($request->validated());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function show(Jadwal $jadwal): View
    {
        $jadwal->load('mapel');

        return view('admin.jadwal.show', compact('jadwal'));
    }

    public function edit(Jadwal $jadwal): View
    {
        $mapels = MataPelajaran::orderBy('nama')->get();
        $jadwal->jam_mulai = substr((string) $jadwal->jam_mulai, 0, 5);
        $jadwal->jam_selesai = substr((string) $jadwal->jam_selesai, 0, 5);

        return view('admin.jadwal.edit', compact('jadwal', 'mapels'));
    }

    public function update(UpdateJadwalRequest $request, Jadwal $jadwal): RedirectResponse
    {
        $jadwal->update($request->validated());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal): RedirectResponse
    {
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
