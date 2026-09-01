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
use App\Models\Guru;

class GuruPolicy
{
    /**
     * Determine if the user can view the guru model.
     */
    public function view(User $user, Guru $guru): bool
    {
        return $user->canViewSchoolTables();
    }

    /**
     * Determine if the user can create a new guru model.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->canManageTeachers();
    }

    /**
     * Determine if the user can update the guru model.
     */
    public function update(User $user, Guru $guru): bool
    {
        return $user->isAdmin() || $user->canManageTeachers();
    }

    /**
     * Determine if the user can delete the guru model.
     */
    public function delete(User $user, Guru $guru): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can restore the guru model.
     */
    public function restore(User $user, Guru $guru): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can force delete the guru model.
     */
    public function forceDelete(User $user, Guru $guru): bool
    {
        return $user->isAdmin();
    }
}