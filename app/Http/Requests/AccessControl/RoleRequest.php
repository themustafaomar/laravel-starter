<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->isMethod('PUT')
            ? $this->user()->can('update roles')
            : $this->user()->can('create roles');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', 'unique:roles,name'.($this->isMethod('PUT') ? ','.$this->role->id : '')],
            'permissions' => ['required', 'array', 'exists:permissions,id'],
        ];
    }
}
