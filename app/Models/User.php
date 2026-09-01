<?php
/**
     * Modernavatarurl.
     *
     * @return public modernAvatarUrl
     */

    /**
     * Avatardata.
     *
     * @return public avatarData
     */

    /**
     * Initials.
     *
     * @return public initials
     */

    /**
     * Avatarurl.
     *
     * @return public avatarUrl
     */

    /**
     * Avatarkey.
     *
     * @return public avatarKey
     */

    /**
     * Rolelabel.
     *
     * @return public roleLabel
     */

    /**
     * Walikelas.
     *
     * @return public waliKelas
     */

    /**
     * Iswalikelas.
     *
     * @return public isWaliKelas
     */

    /**
     * Ismurid.
     *
     * @return public isMurid
     */

    /**
     * Canmanageagenda.
     *
     * @return public canManageAgenda
     */

    /**
     * Canrecorddiscipline.
     *
     * @return public canRecordDiscipline
     */

    /**
     * Canviewschooltables.
     *
     * @return public canViewSchoolTables
     */

    /**
     * Canmanagestudents.
     *
     * @return public canManageStudents
     */

    /**
     * Canmanageteachers.
     *
     * @return public canManageTeachers
     */

    /**
     * Isadministratorlevel.
     *
     * @return public isAdministratorLevel
     */

    /**
     * Isguru.
     *
     * @return public isGuru
     */

    /**
     * Isadminorstaff.
     *
     * @return public isAdminOrStaff
     */

    /**
     * Isstaff.
     *
     * @return public isStaff
     */

    /**
     * Isadmin.
     *
     * @return public isAdmin
     */

    /**
     * Siswa.
     *
     * @return public siswa
     */

    /**
     * Guru.
     *
     * @return public guru
     */

    /**
     * Casts.
     *
     * @return protected casts
     */


namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'avatar', 'role', 'jabatan'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_STAFF = 'staff';

    public const ROLE_GURU = 'guru';

    public const ROLE_MURID = 'murid';

    public const AVATAR_PRESETS = [
        'bocchi' => 'images/bocchi.png',
        'bocchi-shy' => 'images/bocchi-shy.png',
        'bocchi-maid' => 'images/bocchi-maid.png',
    ];

    public const DEFAULT_AVATAR = 'bocchi';

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function guru(): HasOne
    {
        return $this->hasOne(Guru::class);
    }

    public function siswa(): HasOne
    {
        return $this->hasOne(Siswa::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isStaff(): bool
    {
        return $this->role === self::ROLE_STAFF;
    }

    public function isAdminOrStaff(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_STAFF], true);
    }

    public function isGuru(): bool
    {
        return $this->role === self::ROLE_GURU;
    }

    public function isAdministratorLevel(): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (empty($this->jabatan)) {
            return false;
        }

        $jabatan = mb_strtolower(trim($this->jabatan));
        foreach ([
            'kepala sekolah',
            'wakil kepala sekolah',
        ] as $position) {
            if (str_starts_with($jabatan, $position)) {
                return true;
            }
        }

        if (! $this->isStaff()) {
            return false;
        }

        foreach ([
            'kepala tata usaha',
            'staf tu bagian it',
        ] as $position) {
            if (str_starts_with($jabatan, $position)) {
                return true;
            }
        }

        return false;
    }

    public function canManageTeachers(): bool
    {
        return $this->isAdministratorLevel();
    }

    public function canManageStudents(): bool
    {
        return $this->isAdministratorLevel();
    }

    public function canViewSchoolTables(): bool
    {
        return $this->isAdminOrStaff() || $this->isGuru();
    }

    public function canRecordDiscipline(): bool
    {
        return $this->isAdminOrStaff() || $this->isGuru();
    }

    public function canManageAgenda(): bool
    {
        if ($this->isAdmin() || $this->isAdministratorLevel()) {
            return true;
        }

        $jabatan = mb_strtolower((string) $this->jabatan);

        return ($this->isStaff() || $this->isGuru()) && preg_match(
            '/kepala|wakil|kesiswaan|kurikulum|pembina|wali kelas|koordinator/',
            $jabatan
        ) === 1;
    }

    public function isMurid(): bool
    {
        return $this->role === self::ROLE_MURID;
    }

    public function isWaliKelas(): bool
    {
        return $this->isGuru() && ($this->guru?->isWaliKelas() ?? false);
    }

    public function waliKelas(): ?string
    {
        return $this->guru?->wali_kelas;
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN => 'Super Administrator',
            self::ROLE_STAFF => $this->jabatan ?? 'Tenaga Kependidikan',
            self::ROLE_GURU => $this->jabatan ?? 'Tenaga Pendidik (Guru)',
            self::ROLE_MURID => 'Peserta Didik (Siswa)',
            default => ucfirst($this->role),
        };
    }

    public static function avatarPresetKeys(): array
    {
        return array_keys(self::AVATAR_PRESETS);
    }

    public function avatarKey(): string
    {
        if ($this->avatar && array_key_exists($this->avatar, self::AVATAR_PRESETS)) {
            return $this->avatar;
        }

        return self::DEFAULT_AVATAR;
    }

    public function avatarUrl(): string
    {
        return app(\App\Services\AvatarService::class)
            ->getAvatarUrl($this->name, $this->email, $this->avatar);
    }

    public function initials(): string
    {
        $parts = preg_split('/\s+/', trim($this->name)) ?: [];
        $letters = collect($parts)
            ->filter()
            ->take(2)
            ->map(fn (string $part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('');

        return $letters !== '' ? $letters : 'SH';
    }

    /**
     * Get modern avatar data with progressive loading support
     */
    public function avatarData(string $size = 'md'): array
    {
        $avatarService = app(\App\Services\AvatarService::class);
        return $avatarService->getAvatarData($this->name, $this->email, $this->avatar, $size);
    }

    /**
     * Get avatar URL using modern service
     */
    public function modernAvatarUrl(): string
    {
        $avatarService = app(\App\Services\AvatarService::class);
        return $avatarService->getAvatarUrl($this->name, $this->email, $this->avatar);
    }
}
