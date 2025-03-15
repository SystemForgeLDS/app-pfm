<?php

namespace App\Http\Requests;

use App\Constants\UserRoles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // apenas se for sócio ou consultor
        if (auth()->user()->type == UserRoles::PARTNER || auth()->user()->type == UserRoles::CONSULTANT) 
            return true;
        else
            return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $project_id = $this->route('id');

        return [
            // Title is required, must be a string, and max 255 characters
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects', 'title')->ignore($project_id),
                // Rule::unique('projects', 'title')->ignore($this->project_id),
            ],
            'description' => 'required|string', // Description is optional, but if provided, must be a string
            'client_id' => 'required|integer|exists:clients,id', // Client ID is required, must be an integer, and must exist in the clients table
            'end_date' => 'required|date|after_or_equal:today', // End date is required, must be a valid date, and must be today or later
            'status' => 'required|integer', // Status is required and must be one of the specified values
            
            // Value is required, must be a number, and must be 0 or greater
            'value' => [
                'required',
                'min:0',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
        ];
    }

    public function messages()
    {
        return [
            // Title field messages
            'title.required' => 'O campo título é obrigatório.',
            'title.string' => 'O campo título deve ser uma string.',
            'title.max' => 'O campo título não pode ter mais de 255 caracteres.',
            'title.unique' => 'Este título já está em uso. Por favor, escolha outro.',

            // Description field messages
            'description.required' => 'O campo descrição é obrigatório.',
            'description.string' => 'O campo descrição deve ser uma string.',

            // Client ID field messages
            'client_id.required' => 'O campo cliente é obrigatório.',
            'client_id.integer' => 'O campo cliente deve ser um número inteiro.',
            'client_id.exists' => 'O cliente selecionado não existe.',

            // End date field messages
            'end_date.required' => 'O campo data de término é obrigatório.',
            'end_date.date' => 'O campo data de término deve ser uma data válida.',
            'end_date.after_or_equal' => 'A data de término deve ser hoje ou uma data futura.',

            // Status field messages
            'status.required' => 'O campo status é obrigatório.',
            'status.integer' => 'O campo status deve ser um número inteiro.',

            // Value field messages
            'value.required' => 'O campo valor é obrigatório.',
            'value.numeric' => 'O campo valor deve ser um número.',
            'value.min' => 'O campo valor deve ser pelo menos 0.',
            'value.regex' => 'O campo valor deve estar no formato correto (ex: 100,00).',

        ];
    }
}
