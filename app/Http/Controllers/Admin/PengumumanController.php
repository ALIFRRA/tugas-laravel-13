<?php
/**
     * Destroy.
     *
     * @return public destroy
     */

    /**
     * Toggle.
     *
     * @return public toggle
     */

    /**
     * Update.
     *
     * @return public update
     */

    /**
     * Store.
     *
     * @return public store
     */

    /**
     * Index.
     *
     * @return public index
     */


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengumumanController extends Controller
{
    public function index(Request $request): View
    {
        $query = Pengumuman::query();

        if ($request->filled('tipe') && $request->input('tipe') !== 'all') {
            $query->where('tipe', $request->input('tipe'));
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('is_active', $request->input('status') === 'aktif');
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('isi', 'like', "%{$search}%")
                    ->orWhere('penulis', 'like', "%{$search}%");
            });
        }

        $pengumumans = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pengumuman.index', compact('pengumumans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'tipe' => ['required', 'string', 'in:info,penting,mendesak,agenda'],
            'target' => ['required', 'string', 'in:semua,guru,murid'],
            'is_active' => ['nullable', 'boolean'],
            'penulis' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['penulis'] = $validated['penulis'] ?? auth()->user()->name ?? 'Administrator';

        Pengumuman::create($validated);

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman sekolah berhasil dipublikasikan.');
    }

    public function update(Request $request, Pengumuman $pengumuman): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'tipe' => ['required', 'string', 'in:info,penting,mendesak,agenda'],
            'target' => ['required', 'string', 'in:semua,guru,murid'],
            'is_active' => ['nullable', 'boolean'],
            'penulis' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        $pengumuman->update($validated);

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman sekolah berhasil diperbarui.');
    }

    public function toggle(Pengumuman $pengumuman): RedirectResponse
    {
        $pengumuman->update([
            'is_active' => ! $pengumuman->is_active,
        ]);

        $status = $pengumuman->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Pengumuman berhasil {$status}.");
    }

    public function destroy(Pengumuman $pengumuman): RedirectResponse
    {
        $pengumuman->delete();

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
