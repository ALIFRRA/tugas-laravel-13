<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    protected $fillable = [
        'mapel_id',
        'kelas',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }
}
