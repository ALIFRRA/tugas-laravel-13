<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMapelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'kode' => ['required', 'string', 'max:50', Rule::unique('mata_pelajarans', 'kode')->ignore($this->route('mapel'))],
            'guru_id' => ['required', 'exists:gurus,id'],
        ];
    }
}
