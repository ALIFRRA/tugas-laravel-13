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
            'canEdit' => $isOwner || $viewer->isAdmin(),
            'isOwner' => $isOwner,
        ]);
    }

    public function update(UpdateUserProfileRequest $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $viewer = $request->user();

        abort_unless((int) $viewer->id === (int) $user->id || $viewer->isAdmin(), 403);

        $previous = $user->avatar;
        $avatar = $request->input('avatar') ?? $user->avatar;

        if ($request->hasFile('avatar_file')) {
            $path = $request->file('avatar_file')->store('avatars', 'public');
            $avatar = $path;

            // Delete old uploaded file if it was a custom file
            if ($previous && str_starts_with($previous, 'avatars/') && Storage::disk('public')->exists($previous)) {
                Storage::disk('public')->delete($previous);
            }
        }

        $user->update([
            'name' => $request->validated('name'),
            'avatar' => $avatar,
        ]);

        return redirect()
            ->route('profile.show', $user->id)
            ->with('success', 'Profil dan foto akun berhasil diperbarui.');
    }
}
