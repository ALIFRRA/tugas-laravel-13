<?php
/**
     * Handle.
     *
     * @return public handle
     */


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $permissions = [
            'school_tables' => $user->canViewSchoolTables(),
            'discipline_write' => $user->canRecordDiscipline(),
            'agenda_write' => $user->canManageAgenda(),
            'academic_write' => $user->isAdministratorLevel(),
        ];

        foreach ($permissions as $permission => $allowed) {
            if (in_array($permission, $roles, true)) {
                abort_unless($allowed, 403, 'Anda tidak memiliki akses ke halaman ini.');

                return $next($request);
            }
        }

        // Check if administrator level is specified in allowed roles
        if (in_array('admin_level', $roles, true) && $user->isAdministratorLevel()) {
            return $next($request);
        }

        // Check if user's role matches any of the allowed roles
        if (in_array($user->role, $roles, true)) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
