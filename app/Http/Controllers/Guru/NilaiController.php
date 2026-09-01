<?php
/**
     * Assertteachesstudent.
     *
     * @return private assertTeachesStudent
     */

    /**
     * Kelasforguru.
     *
     * @return private kelasForGuru
     */

    /**
     * Assertownsmapel.
     *
     * @return private assertOwnsMapel
     */

    /**
     * Guru.
     *
     * @return private guru
     */

    /**
     * Destroy.
     *
     * @return public destroy
     */

    /**
     * Update.
     *
     * @return public update
     */

    /**
     * Edit.
     *
     * @return public edit
     */

    /**
     * Store.
     *
     * @return public store
     */

    /**
     * Create.
     *
     * @return public create
     */

    /**
     * Index.
     *
     * @return public index
     */


namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNilaiRequest;
use App\Http\Requests\Admin\UpdateNilaiRequest;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NilaiController extends Controller
{
    // daftar nilai guru
    public function index(Request $request): View
    {
        $guru = $this->guru($request);
        $mapelIds = $guru->mataPelajarans()->pluck('id');
        $kelasIds = $this->kelasForGuru($guru);
        $sort = $request->string('sort')->toString() ?: null;

        $nilais = Nilai::query()
            ->with(['siswa', 'mapel'])
            ->whereIn('mapel_id', $mapelIds)
            ->whereHas('siswa', fn ($studentQuery) => $studentQuery->whereIn('kelas', $kelasIds))
            ->applySort($sort)
            ->paginate(10)
            ->appends($request->query());

        return view('guru.nilai.index', [
            'nilais' => $nilais,
            'sort' => $sort,
            'sortOptions' => Nilai::SORT_OPTIONS,
        ]);
    }

    // formulir tambah nilai guru
    public function create(Request $request): View
    {
        $guru = $this->guru($request);
        $kelasIds = $this->kelasForGuru($guru);

        return view('guru.nilai.create', [
            'siswas' => Siswa::whereIn('kelas', $kelasIds)->orderBy('kelas')->orderBy('nama')->get(['id', 'nama', 'nis', 'kelas']),
            'mapels' => $guru->mataPelajarans()->orderBy('nama')->get(['id', 'nama', 'kode']),
        ]);
    }

    // simpan nilai guru
    public function store(StoreNilaiRequest $request): RedirectResponse
    {
        $guru = $this->guru($request);
        $this->assertOwnsMapel($guru, (int) $request->validated('mapel_id'));
        $this->assertTeachesStudent($guru, (int) $request->validated('siswa_id'));

        Nilai::create($request->validated());

        return redirect()->route('guru.nilai.index')->with('success', 'Nilai berhasil ditambahkan.');
    }

    // formulir edit nilai guru
    public function edit(Request $request, Nilai $nilai): View
    {
        $guru = $this->guru($request);
        $this->assertOwnsMapel($guru, (int) $nilai->mapel_id);
        $kelasIds = $this->kelasForGuru($guru);

        return view('guru.nilai.edit', [
            'nilai' => $nilai,
            'siswas' => Siswa::whereIn('kelas', $kelasIds)->orderBy('kelas')->orderBy('nama')->get(['id', 'nama', 'nis', 'kelas']),
            'mapels' => $guru->mataPelajarans()->orderBy('nama')->get(['id', 'nama', 'kode']),
        ]);
    }

    // perbarui nilai guru
    public function update(UpdateNilaiRequest $request, Nilai $nilai): RedirectResponse
    {
        $guru = $this->guru($request);
        $this->assertOwnsMapel($guru, (int) $nilai->mapel_id);
        $this->assertOwnsMapel($guru, (int) $request->validated('mapel_id'));
        $this->assertTeachesStudent($guru, (int) $request->validated('siswa_id'));

        $nilai->update($request->validated());

        return redirect()->route('guru.nilai.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    // hapus nilai guru
    public function destroy(Request $request, Nilai $nilai): RedirectResponse
    {
        $guru = $this->guru($request);
        $this->assertOwnsMapel($guru, (int) $nilai->mapel_id);

        $nilai->delete();

        return redirect()->route('guru.nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }

    // helper profil guru
    private function guru(Request $request): Guru
    {
        $guru = $request->user()->guru;

        abort_unless($guru, 403, 'Profil guru belum terhubung ke akun ini.');

        return $guru;
    }

    // helper otorisasi mapel
    private function assertOwnsMapel(Guru $guru, int $mapelId): void
    {
        $owns = MataPelajaran::query()
            ->where('id', $mapelId)
            ->where('guru_id', $guru->id)
            ->exists();

        abort_unless($owns, 403, 'Mapel ini bukan milik Anda.');
    }

    // helper rombel guru
    private function kelasForGuru(Guru $guru): array
    {
        $jadwalKelas = Jadwal::query()
            ->whereIn('mapel_id', $guru->mataPelajarans()->pluck('id'))
            ->distinct()
            ->pluck('kelas')
            ->all();

        return array_values(array_unique(array_filter([...$jadwalKelas, $guru->wali_kelas])));
    }

    // helper otorisasi siswa
    private function assertTeachesStudent(Guru $guru, int $siswaId): void
    {
        abort_unless(
            Siswa::whereKey($siswaId)->whereIn('kelas', $this->kelasForGuru($guru))->exists(),
            403,
            'Siswa ini bukan bagian dari kelas yang Anda ampu.'
        );
    }
}
