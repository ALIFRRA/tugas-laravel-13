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

class StorePengumumanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'tipe' => ['required', 'string', 'in:info,penting,mendesak,agenda'],
            'target' => ['required', 'string', 'in:semua,guru,murid'],
            'is_active' => ['nullable', 'boolean'],
            'penulis' => ['nullable', 'string', 'max:255'],
        ];
    }
}
