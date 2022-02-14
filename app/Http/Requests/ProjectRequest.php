<?php

namespace App\Http\Requests;

use App\Models\ProjectAttachment;
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
            'name' => ['required', 'string', 'min:4', 'max:255', $unique], 
            'description' => ['required', 'string', 'min:4', 'max:510'], 
            'started_at' => ['required'], 
            'ended_at' => ['required', 'date', "after:{$this->started_at}"],
            'state_id' => ['required', 'exists:project_states,id'], 
            'level_id' => ['required', 'exists:levels,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'flag' => ['string'],
            'attachment.*' => ['max:2048', "mimes:{$this->mimes_type}"]
        ];
    }

    public function messages()
    {
        return [
            'started_at.required' => 'Please Specify Starting Date',
            'ended_at.required' => 'Please Specify Ending Date',
            'ended_at.after' => 'Ending Date Must Be Greater Than Starting Date',
            'state_id.required' => 'Please Select Project States',
            'state_id.exists' => 'Please Select Project States Correctly',
            'level_id.required' => 'Please Select Project Levels',
            'level_id.exists' => 'Please Select Project Levels Correctly',
            'client_id.required' => 'Please Select Project Owner',
            'client_id.exists' => 'Please Select Project Owner Correctly',
            'attachment.*.max' => 'Attachment must not be greater than 2048 kilobytes',
            'attachment.*.mimes' => "Attachment just allowed {$this->mimes_type}",
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'mimes_type' => implode(',', str_replace('.', '', ProjectAttachment::MIME_TYPES))
        ]);
    }
}
