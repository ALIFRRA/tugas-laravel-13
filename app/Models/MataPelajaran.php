<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataPelajaran extends Model
{
    protected $fillable = [
        'nama',
        'kode',
        'guru_id',
    ];

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
