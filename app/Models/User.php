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

#[Fillable(['name', 'email', 'password', 'avatar', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';

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

    public function isGuru(): bool
    {
        return $this->role === self::ROLE_GURU;
    }

    public function isMurid(): bool
    {
        return $this->role === self::ROLE_MURID;
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
        $key = $this->avatarKey();

        if (array_key_exists($key, self::AVATAR_PRESETS)) {
            return asset(self::AVATAR_PRESETS[$key]);
        }

        if ($this->avatar && str_contains($this->avatar, '/')) {
            return Storage::disk('public')->url($this->avatar);
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
