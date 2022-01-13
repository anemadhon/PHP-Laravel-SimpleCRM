<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends FormRequest
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
        $unique = $this->isMethod('PUT') ? Rule::unique('skills')->ignore($this->skill) : '';

        return [
            'name' => ['required', 'string', 'min:1', 'max:20', $unique]
        ];
    }
}
