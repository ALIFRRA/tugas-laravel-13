<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileShowController extends Controller
{
    public function show(Request $request, string $id): View
    {
        $user = User::with(['guru.mataPelajarans', 'siswa.nilais.mapel'])->findOrFail($id);
        $viewer = $request->user();
        $isOwner = (int) $viewer->id === (int) $user->id;
        $canView = $isOwner || $viewer->isAdmin();

        abort_unless($canView, 403);

        return view('profile.show', [
            'user' => $user,
            'avatarPresets' => User::AVATAR_PRESETS,
            'canEdit' => $isOwner,
            'isOwner' => $isOwner,
        ]);
    }

    public function update(UpdateUserProfileRequest $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        abort_unless((int) $request->user()->id === (int) $user->id, 403);

        $previous = $user->avatar;

        $user->update([
            'name' => $request->validated('name'),
            'avatar' => $request->validated('avatar'),
        ]);

        if ($previous && str_contains($previous, '/') && ! array_key_exists($previous, User::AVATAR_PRESETS)) {
            Storage::disk('public')->delete($previous);
        }

        return redirect()
            ->route('profile.show', $user->id)
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
