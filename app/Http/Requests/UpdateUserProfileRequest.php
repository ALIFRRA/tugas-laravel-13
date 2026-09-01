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


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'string'],
            'avatar_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:2048'],
            'avatar_base64' => [
                'nullable',
                'string',
                'max:4194304',
                'regex:/^data:image\/(?:jpeg|png|webp|gif);base64,[A-Za-z0-9+\/\r\n]+=*$/',
            ],
        ];
    }
}
