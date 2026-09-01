<?php
/**
     * Nilais.
     *
     * @return public nilais
     */

    /**
     * Jadwals.
     *
     * @return public jadwals
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

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MataPelajaran extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'kode',
        'guru_id',
    ];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Get the guru that owns this mata pelajaran.
     *
     * @return \App\Models\Guru
     */
    public function guru(): BelongsTo
        {
            return $this->belongsTo(Guru::class);
    }

    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'mapel_id');
    }

    public function nilais(): HasMany
    {
        return $this->hasMany(Nilai::class, 'mapel_id');
    }
}
