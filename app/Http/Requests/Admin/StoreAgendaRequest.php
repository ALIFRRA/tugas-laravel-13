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

class StoreAgendaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'tanggal' => ['required', 'string', 'max:100'],
            'jam' => ['nullable', 'string', 'max:100'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'penanggung_jawab' => ['nullable', 'string', 'max:255'],
            'personel' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:50'],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
