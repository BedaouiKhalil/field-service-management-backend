<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:customers,name'],
            'contact_name' => ['required', 'string', 'max:255'],
            'phone'        => ['required', 'string'],
            'email'        => ['nullable', 'email', 'max:255'],
            'nif'          => ['required', 'string', 'unique:customers,nif'],
            'wilaya_id'    => ['required', 'exists:wilayas,id'],
            'commune_id'   => ['required', 'exists:communes,id'],
            'address'      => ['required', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.string'   => 'Name must be a string.',
            'name.max'      => 'Name may not be greater than 255 characters.',
            'name.unique'   => 'TName already exists.',

            'contact_name.required' => 'contact Name is required.',
            'contact_name.string'   => 'contact Name must be a string.',
            'contact_name.max'      => 'contact Name may not be greater than 255 characters.',

            'phone.required' => 'The phone number is required.',
            'phone.string'   => 'The phone number must be a string.',

            'email.email' => 'The email address is not valid.',
            'email.max'   => 'The email address may not be greater than 255 characters.',

            'nif.required' => 'The NIF is required.',
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
