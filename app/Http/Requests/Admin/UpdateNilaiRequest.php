<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNilaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'siswa_id' => ['required', 'exists:siswas,id'],
            'mapel_id' => ['required', 'exists:mata_pelajarans,id'],
            'jenis_nilai' => ['required', 'string', 'max:100'],
            'nilai' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
