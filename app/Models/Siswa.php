<?php
/**
     * Ekskuls.
     *
     * @return public ekskuls
     */

    /**
     * Totalpoinpelanggaran.
     *
     * @return public totalPoinPelanggaran
     */

    /**
     * Pelanggarans.
     *
     * @return public pelanggarans
     */

    /**
     * Nilais.
     *
     * @return public nilais
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


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'nama',
        'nis',
        'kelas',
        'jenis_kelamin',
        'alamat',
        'tanggal_lahir',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'deleted_at' => 'datetime',
        ];
    }

    public function ekskuls(): BelongsToMany
    {
        return $this->belongsToMany(Ekskul::class, 'ekskul_siswa')
            ->withPivot('posisi', 'tahun_bergabung', 'is_active')
            ->withTimestamps();
    }

    public function nilais(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }

    public function pelanggarans(): HasMany
    {
        return $this->hasMany(Pelanggaran::class);
    }

    public function totalPoinPelanggaran(): int
    {
        return (int) $this->pelanggarans()->sum('poin');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
