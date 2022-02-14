<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:4', 'max:255'],
            'username' => ['required', 'string', 'min:4', 'max:255', Rule::unique('users')->ignore(auth()->user())],
            'email' => ['required', 'email', 'string', 'max:255', Rule::unique('users')->ignore(auth()->user())],
            'password' => ['nullable', 'string', 'confirmed', 'min:8'],
            'skill_id' => ['exists:skills,id']
        ];
    }

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->password == null) {
            $this->request->remove('password');
        }
    }
}