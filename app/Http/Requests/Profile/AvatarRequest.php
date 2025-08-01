<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class AvatarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'avatar' => [
                'required',
                File::types(['jpg', 'jpeg', 'png', 'webp', 'tiff', 'bmp'])
                    ->max(12 * 1024),
            ],
            'coords' => ['required'],
        ];
    }
}
