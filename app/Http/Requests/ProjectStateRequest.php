<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProjectStateRequest extends FormRequest
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
        $unique = $this->isMethod('PUT') ? Rule::unique('project_states')->ignore($this->state) : '';

        return [
            'name' => ['required', 'string', 'min:4', 'max:30', $unique], 
            'for' => ['required', 'string', 'min:3', 'max:9', 'in:dev,non'],
            'description' => ['required', 'string', 'min:4', 'max:510']
        ];
    }
}
