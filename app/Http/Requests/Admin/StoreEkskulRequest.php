<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreEkskulRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'nama_en' => ['nullable', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'pembina' => ['required', 'string', 'max:255'],
            'ketua' => ['nullable', 'string', 'max:255'],
            'anggota' => ['nullable', 'integer', 'min:0'],
            'jadwal' => ['nullable', 'string', 'max:100'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'kegiatan_utama' => ['nullable', 'string'],
            'prestasi' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}