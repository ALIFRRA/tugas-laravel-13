<?php
/**
     * Mapel.
     *
     * @return public mapel
     */

    /**
     * Casts.
     *
     * @return protected casts
     */


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jadwal extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'mapel_id',
        'kelas',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Get the mata pelajaran for this jadwal.
     *
     * @return \App\Models\MataPelajaran
     */
    public function mapel(): BelongsTo
        {
            return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }
}
