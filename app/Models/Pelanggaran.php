<?php
/**
     * Siswa.
     *
     * @return public siswa
     */

    /**
     * Casts.
     *
     * @return protected casts
     */


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pelanggarans';

    protected $fillable = [
        'siswa_id',
        'jenis_pelanggaran',
        'kategori',
        'poin',
        'sanksi',
        'tanggal',
        'guru_pencatat',
        'status',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}
