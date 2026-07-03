<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],

            'description' => ['required', 'string'],

            'customer_id' => [
                'required',
                'integer',
                'exists:customers,id'
            ],

            'technician_id' => [
                'required',
                'integer',
                'exists:users,id'
            ],

            'status' => [
                'nullable',
                Rule::in(TaskStatus::values())
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string'   => 'The title must be a string.',
            'title.max'      => 'The title may not be greater than 255 characters.',

            'description.string' => 'The description must be a valid text.',

            'customer_id.required' => 'The customer field is required.',
            'customer_id.integer'  => 'The customer must be a valid ID.',
            'customer_id.exists'   => 'The selected customer does not exist.',

            'technician_id.required' => 'The technician field is required.',
            'technician_id.integer'  => 'The technician must be valid.',
            'technician_id.exists'   => 'The selected technician does not exist.',

            'status.required' => 'The status field is required.',
            'status.in'       => 'The selected status is invalid.',
        ];
    }
}
