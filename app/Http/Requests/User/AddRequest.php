<?php

namespace App\Http\Requests\User;

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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email'        => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'password'   => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', 'exists:roles,name'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'first_name.string'   => 'First name must be a string.',
            'first_name.max'      => 'First name may not exceed 255 characters.',

            'last_name.required' => 'Last name is required.',
            'last_name.string'   => 'Last name must be a string.',
            'last_name.max'      => 'Last name may not exceed 255 characters.',

            'email.email'  => 'Email must be a valid email address.',
            'email.unique' => 'This email is already taken.',
            'email.max'    => 'Email may not exceed 255 characters.',

            'password.required'  => 'Password is required.',
            'password.min'       => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',

            'role.required' => 'Role is required.',
            'role.exists'   => 'Selected role is invalid.',
        ];
    }
}
