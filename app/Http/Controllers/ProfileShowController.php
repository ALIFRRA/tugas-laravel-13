<?php
/**
     * Update.
     *
     * @return public update
     */

    /**
     * Avatar.
     *
     * @return public avatar
     */

    /**
     * Show.
     *
     * @return public show
     */


namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProfileShowController extends Controller
{
    public function show(Request $request, string $id): View
    {
        $user = User::with(['guru.mataPelajarans', 'siswa.nilais.mapel'])->findOrFail($id);
        $viewer = $request->user();
        $isOwner = (int) $viewer->id === (int) $user->id;
        $canView = $isOwner || $viewer->isAdministratorLevel();

        abort_unless($canView, 403);

        return view('profile.show', [
            'user' => $user,
            'avatarPresets' => User::AVATAR_PRESETS,
            'canEdit' => $isOwner || $viewer->isAdministratorLevel(),
            'isOwner' => $isOwner,
        ]);
    }

    public function avatar(string $filename)
    {
        abort_unless(preg_match('/^[A-Za-z0-9_-]+\.(?:jpg|jpeg|png|webp|gif)$/i', $filename), 404);

        $path = 'avatars/'.$filename;
        abort_unless(Storage::disk('public')->exists($path), 404);

        return response()->file(Storage::disk('public')->path($path), [
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    public function update(UpdateUserProfileRequest $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $viewer = $request->user();

        abort_unless((int) $viewer->id === (int) $user->id || $viewer->isAdministratorLevel(), 403);

        $previous = $user->avatar;
        $avatar = $request->input('avatar') ?? $user->avatar;

        if ($request->hasFile('avatar_file')) {
            $path = $request->file('avatar_file')->store('avatars', 'public');
            $avatar = $path;

            // Delete old uploaded file if it was a custom file
            if ($previous && str_starts_with($previous, 'avatars/') && Storage::disk('public')->exists($previous)) {
                Storage::disk('public')->delete($previous);
            }
        } elseif ($request->filled('avatar_base64')) {
            $base64 = $request->input('avatar_base64');
            $data = explode(',', $base64);
            $decoded = count($data) === 2 ? base64_decode($data[1], true) : false;
            $imageInfo = is_string($decoded) ? @getimagesizefromstring($decoded) : false;
            $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

            if ($decoded === false || strlen($decoded) > 3 * 1024 * 1024 || $imageInfo === false || ! in_array($imageInfo['mime'], $allowedMimes, true)) {
                throw ValidationException::withMessages([
                    'avatar_base64' => 'Format atau ukuran gambar avatar tidak valid.',
                ]);
            }

            if ($imageInfo !== false) {
                $extension = match ($imageInfo['mime']) {
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/webp' => 'webp',
                    'image/gif' => 'gif',
                };
                $filename = 'avatar_'.time().'_'.Str::random(8).'.'.$extension;
                $path = 'avatars/'.$filename;
                Storage::disk('public')->put($path, $decoded);
                $avatar = $path;

                // Delete old uploaded file if it was a custom file
                if ($previous && str_starts_with($previous, 'avatars/') && Storage::disk('public')->exists($previous)) {
                    Storage::disk('public')->delete($previous);
                }
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
