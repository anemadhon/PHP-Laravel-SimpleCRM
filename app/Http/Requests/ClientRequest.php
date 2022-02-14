<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
        $unique = $this->isMethod('PUT') ? Rule::unique('clients')->ignore($this->client) : '';

        return [
            'name' => ['required', 'string', 'min:4', 'max:255', $unique],
            'description' => ['required', 'string', 'max:510'],
            'type_id' => ['required', 'exists:client_types,id']
        ];
    }

    public function messages()
    {
        return [
            'type_id.required' => 'Please select Client Types',
            'type_id.exists' => 'Please select Client Type Correctly'
        ];
    }
}
