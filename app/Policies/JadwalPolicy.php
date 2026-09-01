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
use App\Models\Jadwal;

class JadwalPolicy
{
    /**
     * Determine if the user can view the jadwal model.
     */
    public function view(User $user, Jadwal $jadwal): bool
    {
        return $user->canViewSchoolTables();
    }

    /**
     * Determine if the user can create a new jadwal model.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->canManageAgenda();
    }

    /**
     * Determine if the user can update the jadwal model.
     */
    public function update(User $user, Jadwal $jadwal): bool
    {
        return $user->isAdmin() || ($user->isGuru() && $jadwal->mapel->guru_id === $user->guru->id);
    }

    /**
     * Determine if the user can delete the jadwal model.
     */
    public function delete(User $user, Jadwal $jadwal): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can restore the jadwal model.
     */
    public function restore(User $user, Jadwal $jadwal): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can force delete the jadwal model.
     */
    public function forceDelete(User $user, Jadwal $jadwal): bool
    {
        return $user->isAdmin();
    }
}