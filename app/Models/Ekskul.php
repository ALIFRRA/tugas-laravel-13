<?php
/**
     * Getroutekeyname.
     *
     * @return public getRouteKeyName
     */

    /**
     * Scopeactive.
     *
     * @return public scopeActive
     */

    /**
     * Siswas.
     *
     * @return public siswas
     */


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ekskul extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'nama_en',
        'kategori',
        'pembina',
        'ketua',
        'anggota',
        'jadwal',
        'lokasi',
        'deskripsi',
        'kegiatan_utama',
        'prestasi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'anggota' => 'integer',
        'deleted_at' => 'datetime',
    ];

    public function siswas(): BelongsToMany
    {
        return $this->belongsToMany(Siswa::class, 'ekskul_siswa')
            ->withTimestamps()
            ->withPivot('posisi', 'tahun_bergabung', 'is_active');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }
}