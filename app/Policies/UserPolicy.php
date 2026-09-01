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

    /**
     * Viewany.
     *
     * @return public viewAny
     */


namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine if the user can view other users.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isStaff();
    }

    /**
     * Determine if the user can view the user model.
     */
    public function view(User $user, User $modelUser): bool
    {
        // Admin and staff can view any user
        // Gurus can view users in their class/scope
        // Murids can view their own profile
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        if ($user->isGuru()) {
            // Gurus can view their associated user profile
            return $modelUser->id === $user->id;
        }

        if ($user->isMurid()) {
            return $modelUser->id === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can create a new user model.
     */
    public function create(User $user): bool
    {
        // Admin can create users
        return $user->isAdmin();
    }

    /**
     * Determine if the user can update the user model.
     */
    public function update(User $user, User $modelUser): bool
    {
        // Admin can update any user
        // Users can update their own profile
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->id === $modelUser->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can delete the user model.
     */
    public function delete(User $user, User $modelUser): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can restore the user model.
     */
    public function restore(User $user, User $modelUser): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can force delete the user model.
     */
    public function forceDelete(User $user, User $modelUser): bool
    {
        return $user->isAdmin();
    }
}