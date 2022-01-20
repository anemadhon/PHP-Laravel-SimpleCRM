<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
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
        return [
            'project_id' => ['required', 'exists:projects,id'],
            'pm' => ['required', 'exists:users,id'],
            'dev' => ['required', 'exists:users,id'],
            'qa' => ['required', 'exists:users,id']
        ];
    }

    public function messages()
    {
        return [
            'project_id.required' => 'Please Select Project',
            'project_id.exists' => 'Please Select Project Correctly',
            'pm.required' => 'Please Select Project Manager',
            'pm.exists' => 'Please Select Project Manager Correctly',
            'dev.required' => 'Please Select Developer',
            'dev.exists' => 'Please Select Developer Correctly',
            'qa.required' => 'Please Select Quality Assurance',
            'qa.exists' => 'Please Select Quality Assurance Correctly'
        ];
    }
}
