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
use App\Models\Pelanggaran;

class PelanggaranPolicy
{
    /**
     * Determine if the user can view the pelanggaran model.
     */
    public function view(User $user, Pelanggaran $pelanggaran): bool
    {
        // Admin and staff can view all discipline records
        // Gurus can view records they recorded
        // Murids can view their own records
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        if ($user->isGuru()) {
            return $pelanggaran->guru_pencatat_id === $user->guru->id;
        }

        if ($user->isMurid()) {
            return $pelanggaran->siswa->user_id === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can create a new pelanggaran model.
     */
    public function create(User $user): bool
    {
        // Admin and staff can create discipline records
        // Gurus can record discipline
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        if ($user->isGuru()) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can update the pelanggaran model.
     */
    public function update(User $user, Pelanggaran $pelanggaran): bool
    {
        // Admin and staff can update all records
        // The guru who recorded it can update
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        if ($user->isGuru()) {
            return $pelanggaran->guru_pencatat_id === $user->guru->id;
        }

        return false;
    }

    /**
     * Determine if the user can delete the pelanggaran model.
     */
    public function delete(User $user, Pelanggaran $pelanggaran): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can restore the pelanggaran model.
     */
    public function restore(User $user, Pelanggaran $pelanggaran): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can force delete the pelanggaran model.
     */
    public function forceDelete(User $user, Pelanggaran $pelanggaran): bool
    {
        return $user->isAdmin();
    }
}