<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    public const SORT_OPTIONS = [
        'nilai_desc' => 'Nilai tertinggi',
        'nilai_asc' => 'Nilai terendah',
        'nama_asc' => 'Nama A–Z',
        'nama_desc' => 'Nama Z–A',
    ];

    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'jenis_nilai',
        'nilai',
    ];

    protected function casts(): array
    {
        return [
            'nilai' => 'decimal:2',
        ];
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    public function scopeApplySort(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'nilai_desc' => $query->orderByDesc('nilai'),
            'nilai_asc' => $query->orderBy('nilai'),
            'nama_asc' => $query
                ->join('siswas', 'nilais.siswa_id', '=', 'siswas.id')
                ->select('nilais.*')
                ->orderBy('siswas.nama'),
            'nama_desc' => $query
                ->join('siswas', 'nilais.siswa_id', '=', 'siswas.id')
                ->select('nilais.*')
                ->orderByDesc('siswas.nama'),
            default => $query->latest('nilais.id'),
        };
    }
}
