<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'], 
            'level_id' => ['required', 'exists:levels,id'],
            'project_id' => ['required', 'exists:projects,id'],
            'assigned_to' => ['required', 'exists:users,id']
        ];
    }

    public function messages()
    {
        return [
            'level_id.required' => 'Please Select Project Levels',
            'level_id.exists' => 'Please Select Project Levels Correctly',
            'project_id.required' => 'Please Select Project',
            'project_id.exists' => 'Please Select Project Correctly',
            'assigned_to.required' => 'Please Select User',
            'assigned_to.exists' => 'Please Select User Correctly'
        ];
    }
}
