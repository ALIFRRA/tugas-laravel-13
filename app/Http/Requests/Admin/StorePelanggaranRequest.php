<?php
/**
     * Rules.
     *
     * @return public rules
     */

    /**
     * Authorize.
     *
     * @return public authorize
     */


namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePelanggaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'siswa_id' => ['required', 'exists:siswas,id'],
            'jenis_pelanggaran' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'in:Ringan,Sedang,Berat'],
            'poin' => ['required', 'integer', 'min:1', 'max:100'],
            'sanksi' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'string', 'max:100'],
            'guru_pencatat' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:Dalam Pembinaan,Selesai,Ditindaklanjuti'],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
