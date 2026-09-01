<?php
/**
     * Forcedelete.
     *
     * @return public forceDelete
     */

    /**
     * Restore.
     *
     * @return public restore
     */

    /**
     * Delete.
     *
     * @return public delete
     */

    /**
     * Update.
     *
     * @return public update
     */

    /**
     * Create.
     *
     * @return public create
     */

    /**
     * View.
     *
     * @return public view
     */


namespace App\Policies;

use App\Models\User;
use App\Models\Nilai;

class NilaiPolicy
{
    /**
     * Determine if the user can view the nilai model.
     */
    public function view(User $user, Nilai $nilai): bool
    {
        // Admin and staff can view all grades
        // Gurus can view grades for their students/classes
        // Murids can view their own grades
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        if ($user->isGuru()) {
            return $nilai->mapel->guru_id === $user->guru->id;
        }

        if ($user->isMurid()) {
            return $nilai->siswa->user_id === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can create a new nilai model.
     */
    public function create(User $user, ?Nilai $nilai = null): bool
    {
        // Admin and staff can create grades
        // Gurus can create grades for their subjects
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        if ($user->isGuru() && $nilai instanceof Nilai) {
            return $nilai->mapel->guru_id === $user->guru->id;
        }

        return false;
    }

    /**
     * Determine if the user can update the nilai model.
     */
    public function update(User $user, Nilai $nilai): bool
    {
        // Admin and staff can update all grades
        // Gurus can update grades for their subjects
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        if ($user->isGuru()) {
            return $nilai->mapel->guru_id === $user->guru->id;
        }

        // Murids can only update their own grades
        if ($user->isMurid()) {
            return $nilai->siswa->user_id === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can delete the nilai model.
     */
    public function delete(User $user, Nilai $nilai): bool
    {
        return $user->isAdmin() || ($user->isStaff() && $nilai->mapel->guru_id === $user->guru->id);
    }

    /**
     * Determine if the user can restore the nilai model.
     */
    public function restore(User $user, Nilai $nilai): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can force delete the nilai model.
     */
    public function forceDelete(User $user, Nilai $nilai): bool
    {
        return $user->isAdmin();
    }
}