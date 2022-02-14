<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $unique = $this->isMethod('PUT') ? Rule::unique('roles')->ignore($this->role) : '';

        return [
            'name' => ['required', 'string', 'min:4', 'max:30', $unique], 
            'description' => ['required', 'string', 'min:4', 'max:510']
        ];
    }
}
