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
use App\Models\MataPelajaran;

class MataPelajaranPolicy
{
    /**
     * Determine if the user can view the mata pelajaran model.
     */
    public function view(User $user, MataPelajaran $mataPelajaran): bool
    {
        return $user->canViewSchoolTables();
    }

    /**
     * Determine if the user can create a new mata pelajaran model.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->canManageTeachers();
    }

    /**
     * Determine if the user can update the mata pelajaran model.
     */
    public function update(User $user, MataPelajaran $mataPelajaran): bool
    {
        return $user->isAdmin() || ($user->isGuru() && $mataPelajaran->guru_id === $user->guru->id);
    }

    /**
     * Determine if the user can delete the mata pelajaran model.
     */
    public function delete(User $user, MataPelajaran $mataPelajaran): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can restore the mata pelajaran model.
     */
    public function restore(User $user, MataPelajaran $mataPelajaran): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can force delete the mata pelajaran model.
     */
    public function forceDelete(User $user, MataPelajaran $mataPelajaran): bool
    {
        return $user->isAdmin();
    }
}