<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],

            'description' => ['nullable', 'string'],

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
            'title.required' => 'Le titre est obligatoire.',
            'title.string'   => 'Le titre doit être une chaîne de caractères.',
            'title.max'      => 'Le titre ne doit pas dépasser 255 caractères.',

            'description.string' => 'La description doit être un texte valide.',

            'customer_id.required' => 'Le client est obligatoire.',
            'customer_id.integer'  => 'Le client doit être un identifiant valide.',
            'customer_id.exists'   => 'Le client sélectionné n\'existe pas.',

            'technician_id.required' => 'L\'utilisateur assigné est obligatoire.',
            'technician_id.integer'  => 'L\'utilisateur assigné doit être valide.',
            'technician_id.exists'   => 'L\'utilisateur sélectionné n\'existe pas.',

            'status.required' => 'Le statut est obligatoire.',
            'status.in'       => 'Le statut sélectionné est invalide.',
        ];
    }
}
