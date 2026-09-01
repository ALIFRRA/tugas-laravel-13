<?php
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
     * Show.
     *
     * @return public show
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
     * Apiindex.
     *
     * @return public apiIndex
     */

    /**
     * Index.
     *
     * @return public index
     */


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGuruRequest;
use App\Http\Requests\Admin\UpdateGuruRequest;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class GuruController extends Controller
{
    public function index(Request $request): View
    {
        $query = Guru::query()->with(['user', 'mataPelajarans']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhereHas('mataPelajarans', function ($mapelQuery) use ($search) {
                        $mapelQuery->where('nama', 'like', "%{$search}%")
                            ->orWhere('kode', 'like', "%{$search}%");
                    });
            });
        }

        $gurus = $query->orderBy('nip')->paginate(15)->withQueryString();

        return view('admin.guru.index', compact('gurus'));
    }

    public function apiIndex(): JsonResponse
    {
        $gurus = Guru::query()
            ->with(['user', 'mataPelajarans'])
            ->orderBy('nama')
            ->get()
            ->map(fn (Guru $guru): array => [
                'id' => $guru->id,
                'nama' => $guru->nama,
                'nip' => $guru->nip,
                'email' => $guru->user?->email,
                'no_telepon' => $guru->no_telepon,
                'mata_pelajaran' => $guru->mataPelajarans->pluck('nama')->values(),
            ]);

        return response()->json(['data' => $gurus]);
    }

    public function create(): View
    {
        return view('admin.guru.create');
    }

    public function store(StoreGuruRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $userId = null;
            if (! empty($validated['email'])) {
                $userId = User::create([
                    'name' => $validated['nama'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => User::ROLE_GURU,
                ])->id;
            }

            Guru::create([
                'user_id' => $userId,
                'nama' => $validated['nama'],
                'nip' => $validated['nip'],
                'no_telepon' => $validated['no_telepon'],
            ]);
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function show(Guru $guru): View
    {
        $guru->load('user', 'mataPelajarans');

        return view('admin.guru.show', compact('guru'));
    }

    public function edit(Guru $guru): View
    {
        $guru->load('user');

        return view('admin.guru.edit', compact('guru'));
    }

    public function update(UpdateGuruRequest $request, Guru $guru): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $guru) {
            if (! empty($validated['email'])) {
                if ($guru->user) {
                    $userData = ['name' => $validated['nama'], 'email' => $validated['email']];
                    if (! empty($validated['password'])) {
                        $userData['password'] = Hash::make($validated['password']);
                    }
                    $guru->user->update($userData);
                } else {
                    $guru->user_id = User::create([
                        'name' => $validated['nama'],
                        'email' => $validated['email'],
                        'password' => Hash::make($validated['password']),
                        'role' => User::ROLE_GURU,
                    ])->id;
                }
            }

            $guru->update([
                'user_id' => $guru->user_id,
                'nama' => $validated['nama'],
                'nip' => $validated['nip'],
                'no_telepon' => $validated['no_telepon'],
            ]);
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru): RedirectResponse
    {
        if ($guru->mataPelajarans()->exists()) {
            return back()->with('error', 'Guru tidak dapat dihapus selama masih memiliki mata pelajaran yang ditautkan. Pindahkan mata pelajaran tersebut terlebih dahulu.');
        }

        if ($guru->user) {
            $guru->user->delete();
        }
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
