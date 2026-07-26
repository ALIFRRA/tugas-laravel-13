<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'nip',
        'mata_pelajaran',
        'no_telepon',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mataPelajarans(): HasMany
    {
        return $this->hasMany(MataPelajaran::class);
    }
}
