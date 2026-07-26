<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJadwalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mapel_id' => ['required', 'exists:mata_pelajarans,id'],
            'kelas' => ['required', 'string', 'max:50'],
            'hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'])],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
        ];
    }

    protected function prepareForValidation(): void
    {
        foreach (['jam_mulai', 'jam_selesai'] as $field) {
            if ($this->filled($field)) {
                $this->merge([$field => substr((string) $this->input($field), 0, 5)]);
            }
        }
    }
}
