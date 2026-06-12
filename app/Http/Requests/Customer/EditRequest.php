<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('customers', 'name')->ignore($this->customer->id),
            ],
            'nif' => [
                'nullable',
                'string',
                Rule::unique('customers', 'nif')->ignore($this->customer->id),
            ],
            'contact_name' => ['required', 'string', 'max:255'],
            'phone'        => ['required', 'string'],
            'email'        => ['nullable', 'email', 'max:255'],
            'wilaya_id'    => ['required', 'exists:wilayas,id'],
            'commune_id'   => ['required', 'exists:communes,id'],
            'address'      => ['required', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The company name is required.',
            'name.string'   => 'The company name must be a string.',
            'name.max'      => 'The company name may not be greater than 255 characters.',
            'name.unique'   => 'This company name already exists.',

            'phone.required' => 'The phone number is required.',
            'phone.string'   => 'The phone number must be a string.',

            'email.email' => 'The email address is not valid.',
            'email.max'   => 'The email address may not be greater than 255 characters.',

            'nif.string' => 'The NIF must be a string.',
            'nif.unique' => 'This NIF already exists.',

            'wilaya_id.required' => 'The wilaya field is required.',
            'wilaya_id.exists'   => 'The selected wilaya is invalid.',

            'commune_id.required' => 'The commune field is required.',
            'commune_id.exists'   => 'The selected commune is invalid.',

            'address.required' => 'The address is required.',
            'address.string'   => 'The address must be a string.',
            'address.max'      => 'The address may not be greater than 500 characters.',
        ];
    }

}
