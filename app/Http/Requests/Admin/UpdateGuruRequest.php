<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:50', Rule::unique('gurus', 'nip')->ignore($this->route('guru'))],
            'mata_pelajaran' => ['required', 'string', 'max:255'],
            'no_telepon' => ['required', 'string', 'max:20'],
        ];
    }
}
