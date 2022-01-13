<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
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
        $unique = $this->isMethod('PUT') ? Rule::unique('projects')->ignore($this->project) : '';

        return [
            'name' => ['required', 'string', 'max:255', $unique], 
            'description' => ['required', 'string', 'max:510'], 
            'started_at' => ['required'], 
            'ended_at' => ['required'],
            'state_id' => ['required', 'exists:project_states,id'], 
            'level_id' => ['required', 'exists:levels,id'],
            'client_id' => ['required', 'exists:clients,id']
        ];
    }

    public function messages()
    {
        return [
            'state_id.required' => 'Please Select Project States',
            'state_id.exists' => 'Please Select Project States Correctly',
            'level_id.required' => 'Please Select Project Levels',
            'level_id.exists' => 'Please Select Project Levels Correctly',
            'client_id.required' => 'Please Select Project Owner',
            'client_id.exists' => 'Please Select Project Owner Correctly',
        ];
    }
}
