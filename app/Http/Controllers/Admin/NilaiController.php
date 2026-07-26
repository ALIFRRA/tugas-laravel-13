<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNilaiRequest;
use App\Http\Requests\Admin\UpdateNilaiRequest;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NilaiController extends Controller
{
    public function index(Request $request): View
    {
        $sort = $request->string('sort')->toString() ?: null;

        $nilais = Nilai::query()
            ->with(['siswa', 'mapel'])
            ->applySort($sort)
            ->paginate(10)
            ->appends($request->query());

        return view('admin.nilai.index', [
            'nilais' => $nilais,
            'sort' => $sort,
            'sortOptions' => Nilai::SORT_OPTIONS,
        ]);
    }

    public function create(): View
    {
        $siswas = Siswa::orderBy('nama')->get();
        $mapels = MataPelajaran::orderBy('nama')->get();

        return view('admin.nilai.create', compact('siswas', 'mapels'));
    }

    public function store(StoreNilaiRequest $request): RedirectResponse
    {
        Nilai::create($request->validated());

        return redirect()->route('admin.nilai.index')->with('success', 'Nilai berhasil ditambahkan.');
    }

    public function show(Nilai $nilai): View
    {
        $nilai->load(['siswa', 'mapel']);

        return view('admin.nilai.show', compact('nilai'));
    }

    public function edit(Nilai $nilai): View
    {
        $siswas = Siswa::orderBy('nama')->get();
        $mapels = MataPelajaran::orderBy('nama')->get();

        return view('admin.nilai.edit', compact('nilai', 'siswas', 'mapels'));
    }

    public function update(UpdateNilaiRequest $request, Nilai $nilai): RedirectResponse
    {
        $nilai->update($request->validated());

        return redirect()->route('admin.nilai.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy(Nilai $nilai): RedirectResponse
    {
        $nilai->delete();

        return redirect()->route('admin.nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }
}
