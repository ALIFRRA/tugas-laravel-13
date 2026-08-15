<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

#[Fillable(['name', 'email', 'password', 'avatar', 'role', 'jabatan'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
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

        if (! empty($this->jabatan)) {
            $jabatanLower = mb_strtolower($this->jabatan);
            $adminKeywords = [
                'kepala sekolah',
                'kepsek',
                'wakil kepala sekolah',
                'wakepsek',
                'kepala tata usaha',
                'kepala tu',
                'it',
                'administrator',
                'sistem',
            ];

            foreach ($adminKeywords as $keyword) {
                if (str_contains($jabatanLower, $keyword)) {
                    return true;
                }
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
        return $this->isAdmin() || $this->isStaff() || $this->isGuru();
    }

    public function isMurid(): bool
    {
        return $this->role === self::ROLE_MURID;
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
        if ($this->avatar) {
            if (str_starts_with($this->avatar, 'avatars/') || str_contains($this->avatar, '/')) {
                if (Storage::disk('public')->exists($this->avatar)) {
                    return Storage::disk('public')->url($this->avatar);
                }
                if (file_exists(public_path($this->avatar))) {
                    return asset($this->avatar);
                }
            }

            if (array_key_exists($this->avatar, self::AVATAR_PRESETS)) {
                return asset(self::AVATAR_PRESETS[$this->avatar]);
            }
        }

        return asset(self::AVATAR_PRESETS[self::DEFAULT_AVATAR]);
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
}
