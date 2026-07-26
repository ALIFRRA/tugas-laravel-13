<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreMapelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'kode' => ['required', 'string', 'max:50', 'unique:mata_pelajarans,kode'],
            'guru_id' => ['required', 'exists:gurus,id'],
        ];
    }
}
