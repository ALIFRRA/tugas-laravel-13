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
use App\Models\Ekskul;

class EkskulPolicy
{
    /**
     * Determine if the user can view the ekskul model.
     */
    public function view(User $user, Ekskul $ekskul): bool
    {
        // Admin and staff can view all extracurricular activities
        // Gurus can view extracurricular activities they manage
        // Murids can view active extracurricular activities
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        if ($user->isGuru()) {
            return $ekskul->pembina === $user->name || $ekskul->ketua === $user->name;
        }

        if ($user->isMurid()) {
            return $ekskul->is_active;
        }

        return false;
    }

    /**
     * Determine if the user can create a new ekskul model.
     */
    public function create(User $user): bool
    {
        // Admin and staff can create extracurricular activities
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        if ($user->isGuru()) {
            return $user->canManageAgenda();
        }

        return false;
    }

    /**
     * Determine if the user can update the ekskul model.
     */
    public function update(User $user, Ekskul $ekskul): bool
    {
        // Admin and staff can update all extracurricular activities
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        if ($user->isGuru()) {
            return $ekskul->pembina === $user->name || $ekskul->ketua === $user->name;
        }

        return false;
    }

    /**
     * Determine if the user can delete the ekskul model.
     */
    public function delete(User $user, Ekskul $ekskul): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can restore the ekskul model.
     */
    public function restore(User $user, Ekskul $ekskul): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can force delete the ekskul model.
     */
    public function forceDelete(User $user, Ekskul $ekskul): bool
    {
        return $user->isAdmin();
    }
}