<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNilaiRequest;
use App\Http\Requests\Admin\UpdateNilaiRequest;
use App\Models\Guru;
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
        $guru = $this->guru($request);
        $mapelIds = $guru->mataPelajarans()->pluck('id');
        $sort = $request->string('sort')->toString() ?: null;

        $nilais = Nilai::query()
            ->with(['siswa', 'mapel'])
            ->whereIn('mapel_id', $mapelIds)
            ->applySort($sort)
            ->paginate(10)
            ->appends($request->query());

        return view('guru.nilai.index', [
            'nilais' => $nilais,
            'sort' => $sort,
            'sortOptions' => Nilai::SORT_OPTIONS,
        ]);
    }

    public function create(Request $request): View
    {
        $guru = $this->guru($request);

        return view('guru.nilai.create', [
            'siswas' => Siswa::orderBy('nama')->get(),
            'mapels' => $guru->mataPelajarans()->orderBy('nama')->get(),
        ]);
    }

    public function store(StoreNilaiRequest $request): RedirectResponse
    {
        $guru = $this->guru($request);
        $this->assertOwnsMapel($guru, (int) $request->validated('mapel_id'));

        Nilai::create($request->validated());

        return redirect()->route('guru.nilai.index')->with('success', 'Nilai berhasil ditambahkan.');
    }

    public function edit(Request $request, Nilai $nilai): View
    {
        $guru = $this->guru($request);
        $this->assertOwnsMapel($guru, (int) $nilai->mapel_id);

        return view('guru.nilai.edit', [
            'nilai' => $nilai,
            'siswas' => Siswa::orderBy('nama')->get(),
            'mapels' => $guru->mataPelajarans()->orderBy('nama')->get(),
        ]);
    }

    public function update(UpdateNilaiRequest $request, Nilai $nilai): RedirectResponse
    {
        $guru = $this->guru($request);
        $this->assertOwnsMapel($guru, (int) $nilai->mapel_id);
        $this->assertOwnsMapel($guru, (int) $request->validated('mapel_id'));

        $nilai->update($request->validated());

        return redirect()->route('guru.nilai.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy(Request $request, Nilai $nilai): RedirectResponse
    {
        $guru = $this->guru($request);
        $this->assertOwnsMapel($guru, (int) $nilai->mapel_id);

        $nilai->delete();

        return redirect()->route('guru.nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }

    private function guru(Request $request): Guru
    {
        $guru = $request->user()->guru;

        abort_unless($guru, 403, 'Profil guru belum terhubung ke akun ini.');

        return $guru;
    }

    private function assertOwnsMapel(Guru $guru, int $mapelId): void
    {
        $owns = MataPelajaran::query()
            ->where('id', $mapelId)
            ->where('guru_id', $guru->id)
            ->exists();

        abort_unless($owns, 403, 'Mapel ini bukan milik Anda.');
    }
}
