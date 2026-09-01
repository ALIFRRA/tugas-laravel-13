<?php
/**
     * Casts.
     *
     * @return protected casts
     */


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'judul',
        'kategori',
        'tanggal',
        'jam',
        'lokasi',
        'penanggung_jawab',
        'personel',
        'status',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }
}
