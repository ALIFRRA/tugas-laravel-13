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
use App\Models\Pengumuman;

class PengumumanPolicy
{
    /**
     * Determine if the user can view the pengumuman model.
     */
    public function view(User $user, Pengumuman $pengumuman): bool
    {
        // Admin and staff can view all announcements
        // Gurus can view announcements
        // Murids can view active announcements
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        if ($user->isGuru()) {
            return true;
        }

        if ($user->isMurid()) {
            return $pengumuman->is_active;
        }

        return false;
    }

    /**
     * Determine if the user can create a new pengumuman model.
     */
    public function create(User $user): bool
    {
        // Admin and staff can create announcements
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        if ($user->isGuru()) {
            return $user->canManageAgenda();
        }

        return false;
    }

    /**
     * Determine if the user can update the pengumuman model.
     */
    public function update(User $user, Pengumuman $pengumuman): bool
    {
        // Admin and staff can update all announcements
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        if ($user->isGuru()) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can delete the pengumuman model.
     */
    public function delete(User $user, Pengumuman $pengumuman): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can restore the pengumuman model.
     */
    public function restore(User $user, Pengumuman $pengumuman): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can force delete the pengumuman model.
     */
    public function forceDelete(User $user, Pengumuman $pengumuman): bool
    {
        return $user->isAdmin();
    }
}