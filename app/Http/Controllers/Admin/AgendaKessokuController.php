<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgendaKessokuController extends Controller
{
    public function index(Request $request): View
    {
        $query = Agenda::query();

        if ($request->filled('kategori') && $request->input('kategori') !== 'all') {
            $query->where('kategori', $request->input('kategori'));
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('penanggung_jawab', 'like', "%{$search}%")
                  ->orWhere('personel', 'like', "%{$search}%");
            });
        }

        $agendas = $query->latest()->paginate(12)->withQueryString();

        $totalAgenda = Agenda::count();
        $aktifCount = Agenda::where('status', 'Aktif')->count();
        $persiapanCount = Agenda::where('status', 'Persiapan')->count();
        $mendatangCount = Agenda::where('status', 'Mendatang')->count();

        return view('admin.agenda.index', compact('agendas', 'totalAgenda', 'aktifCount', 'persiapanCount', 'mendatangCount'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'tanggal' => ['required', 'string', 'max:100'],
            'jam' => ['nullable', 'string', 'max:100'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'penanggung_jawab' => ['nullable', 'string', 'max:255'],
            'personel' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:50'],
            'catatan' => ['nullable', 'string'],
        ]);

        Agenda::create($validated);

        return redirect()
            ->route('admin.agenda.index')
            ->with('success', 'Agenda sekolah berhasil ditambahkan.');
    }

    public function update(Request $request, Agenda $agenda): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'tanggal' => ['required', 'string', 'max:100'],
            'jam' => ['nullable', 'string', 'max:100'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'penanggung_jawab' => ['nullable', 'string', 'max:255'],
            'personel' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:50'],
            'catatan' => ['nullable', 'string'],
        ]);

        $agenda->update($validated);

        return redirect()
            ->route('admin.agenda.index')
            ->with('success', 'Agenda sekolah berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda): RedirectResponse
    {
        $agenda->delete();

        return redirect()
            ->route('admin.agenda.index')
            ->with('success', 'Agenda sekolah berhasil dihapus.');
    }
}
