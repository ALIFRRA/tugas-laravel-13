<?php
/**
     * Getmatapelajaranattribute.
     *
     * @return public getMataPelajaranAttribute
     */

    /**
     * Matapelajarans.
     *
     * @return public mataPelajarans
     */

    /**
     * User.
     *
     * @return public user
     */

    /**
     * Casts.
     *
     * @return protected casts
     */

    /**
     * Iswalikelas.
     *
     * @return public isWaliKelas
     */


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nama',
        'nip',
        'no_telepon',
        'wali_kelas',
    ];

    public function isWaliKelas(): bool
    {
        return ! empty($this->wali_kelas);
    }

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mataPelajarans(): HasMany
    {
        return $this->hasMany(MataPelajaran::class);
    }

    /**
     * Backwards-compatible display value for screens that show a teacher's
     * subject area. Subjects are now stored in mata_pelajarans, not gurus.
     */
    public function getMataPelajaranAttribute(): ?string
    {
        $subjects = $this->relationLoaded('mataPelajarans')
            ? $this->mataPelajarans
            : $this->mataPelajarans()->get();

        return $subjects->pluck('nama')->implode(', ') ?: null;
    }
}
