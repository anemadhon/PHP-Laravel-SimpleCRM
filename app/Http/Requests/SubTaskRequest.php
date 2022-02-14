<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SubTaskRequest extends FormRequest
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
        $unique = $this->isMethod('PUT') ? Rule::unique('sub_tasks')->ignore($this->sub) : '';
        
        return [
            'task_id' => ['required', 'exists:tasks,id'],
            'name' => ['required', 'string', 'min:4', 'max:255', $unique],
            'level_id' => ['required', 'exists:levels,id'],
            'state_id' => ['required', 'exists:project_states,id'],
        ];
    }

    public function messages()
    {
        return [
            'level_id.required' => 'Please Select Project Levels',
            'level_id.exists' => 'Please Select Project Levels Correctly',
            'state_id.required' => 'Please Select Project states',
            'state_id.exists' => 'Please Select Project states Correctly',
            'task_id.required' => 'Please Select Project Correctly',
            'task_id.exists' => 'Please Select Project Correctly',
        ];
    }
}
