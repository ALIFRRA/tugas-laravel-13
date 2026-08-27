<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEkskulRequest;
use App\Http\Requests\Admin\UpdateEkskulRequest;
use App\Models\Ekskul;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EkskulController extends Controller
{
    public function index(Request $request): View
    {
        $query = Ekskul::query()->withCount('siswas');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('pembina', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori') && $request->input('kategori') !== 'all') {
            $query->where('kategori', $request->input('kategori'));
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('is_active', $request->input('status') === 'active');
        }

        $ekskuls = $query->orderBy('kategori')->orderBy('nama')->paginate(12)->withQueryString();

        $kategoriList = Ekskul::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        return view('admin.ekskul.index', compact('ekskuls', 'kategoriList'));
    }

    public function create(): View
    {
        return view('admin.ekskul.create');
    }

    public function store(StoreEkskulRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        Ekskul::create($data);

        return redirect()->route('admin.ekskul.index')->with('success', 'Klub ekstrakurikuler berhasil ditambahkan.');
    }

    public function show(Ekskul $ekskul): View
    {
        $ekskul->loadCount('siswas');
        return view('admin.ekskul.show', compact('ekskul'));
    }

    public function edit(Ekskul $ekskul): View
    {
        return view('admin.ekskul.edit', compact('ekskul'));
    }

    public function update(UpdateEkskulRequest $request, Ekskul $ekskul): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        if ($ekskul->siswas()->exists()) {
            $data['anggota'] = $ekskul->siswas()->count();
        }
        $ekskul->update($data);

        return redirect()->route('admin.ekskul.index')->with('success', 'Data klub berhasil diperbarui.');
    }

    public function destroy(Ekskul $ekskul): RedirectResponse
    {
        $ekskul->delete();

        return redirect()->route('admin.ekskul.index')->with('success', 'Klub ekstrakurikuler berhasil dihapus.');
    }

    public function members(Ekskul $ekskul): View
    {
        $ekskul->load(['siswas' => function ($query) {
            $query->withPivot('posisi', 'tahun_bergabung', 'is_active')
                  ->orderBy('ekskul_siswa.posisi')
                  ->orderBy('nama');
        }])->loadCount('siswas');

        $siswas = Siswa::orderBy('nama')->get();

        return view('admin.ekskul.members', compact('ekskul', 'siswas'));
    }

    public function addMember(Request $request, Ekskul $ekskul): RedirectResponse
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'posisi' => 'required|string|in:Anggota,Ketua,Wakil Ketua,Sekretaris,Bendahara',
            'tahun_bergabung' => 'required|integer|min:2020|max:2030',
        ]);

        if ($ekskul->siswas()->where('siswa_id', $request->siswa_id)->exists()) {
            return back()->withErrors(['siswa_id' => 'Siswa sudah menjadi anggota klub ini.']);
        }

        $ekskul->siswas()->attach($request->siswa_id, [
            'posisi' => $request->posisi,
            'tahun_bergabung' => $request->tahun_bergabung,
            'is_active' => true,
        ]);
        $this->syncMemberCount($ekskul);

        return redirect()->route('admin.ekskul.members', $ekskul)->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function removeMember(Ekskul $ekskul, Siswa $siswa): RedirectResponse
    {
        if (! $ekskul->siswas()->whereKey($siswa->id)->exists()) {
            return back()->with('error', 'Siswa ini bukan anggota klub yang dipilih.');
        }

        $ekskul->siswas()->detach($siswa->id);
        $this->syncMemberCount($ekskul);

        return redirect()->route('admin.ekskul.members', $ekskul)->with('success', 'Anggota berhasil dihapus dari klub.');
    }

    public function updateMember(Request $request, Ekskul $ekskul, Siswa $siswa): RedirectResponse
    {
        $request->validate([
            'posisi' => 'required|string|in:Anggota,Ketua,Wakil Ketua,Sekretaris,Bendahara',
        ]);

        if (! $ekskul->siswas()->whereKey($siswa->id)->exists()) {
            return back()->with('error', 'Siswa ini bukan anggota klub yang dipilih.');
        }

        $ekskul->siswas()->updateExistingPivot($siswa->id, [
            'posisi' => $request->posisi,
        ]);

        return redirect()->route('admin.ekskul.members', $ekskul)->with('success', 'Posisi anggota berhasil diperbarui.');
    }

    private function syncMemberCount(Ekskul $ekskul): void
    {
        $ekskul->update(['anggota' => $ekskul->siswas()->count()]);
    }
}
