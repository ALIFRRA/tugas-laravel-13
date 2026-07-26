<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:50', 'unique:siswas,nis'],
            'kelas' => ['required', 'string', 'max:50'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'alamat' => ['required', 'string'],
            'tanggal_lahir' => ['required', 'date'],
        ];
    }
}
