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
use App\Models\Siswa;

class SiswaPolicy
{
    /**
     * Determine if the user can view the siswa model.
     */
    public function view(User $user, Siswa $siswa): bool
    {
        // Admin and staff can view all students
        // Gurus (wali kelas) can view students in their class
        // Murids can view their own data
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        if ($user->isGuru()) {
            // Wali kelas can view their class students
            return $user->isWaliKelas() && $siswa->kelas === $user->guru->wali_kelas;
        }

        if ($user->isMurid()) {
            return $siswa->user_id === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can create a new siswa model.
     */
    public function create(User $user): bool
    {
        // Admin and staff can create students
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can update the siswa model.
     */
    public function update(User $user, Siswa $siswa): bool
    {
        // Admin and staff can update all students
        // Wali kelas can update students in their class
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        if ($user->isGuru()) {
            return $user->isWaliKelas() && $siswa->kelas === $user->guru->wali_kelas;
        }

        return false;
    }

    /**
     * Determine if the user can delete the siswa model.
     */
    public function delete(User $user, Siswa $siswa): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can restore the siswa model.
     */
    public function restore(User $user, Siswa $siswa): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can force delete the siswa model.
     */
    public function forceDelete(User $user, Siswa $siswa): bool
    {
        return $user->isAdmin();
    }
}