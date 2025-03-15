<?php

namespace App\Http\Requests;

use App\Constants\UserRoles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{

    // protected $redirectRoute = 'clients.index';

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
        return [
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'value' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:0',
            'predicted_hour' => 'required|numeric|min:0|max:1000',
            'completed' => 'in:0,1',
            'real_hour' => [
                'nullable',
                'numeric',
                'min:0',
                'max:1000',
                // 'real_hour' é obrigatório apenas se 'completed' for 1
                Rule::requiredIf($this->input('completed') == 1),
            ],
        ];
    }

    public function messages()
    {
        return [
            // Mensagens para o campo 'title'
            'title.required' => '"título" é obrigatório.',
            'title.string' => 'Insira um título válido.',
            'title.max' => 'Insira um título menor.',

            // Mensagens para o campo 'description'
            'description.required' => '"descrição" é obrigatório.',
            'description.string' => 'Insira uma descrição válida.',
            'description.max' => 'Insira uma descrição menor.',

            // Mensagens para o campo 'value'
            'value.required' => '"valor" é obrigatório.',
            'value.regex' => '"valor" deve ser um número válido.',
            'value.min' => '"valor" deve ser um número positivo.',

            // Mensagens para o campo 'predicted_hour'
            'predicted_hour.required' => '"hora prevista" é obrigatório.',
            'predicted_hour.numeric' => '"hora prevista" deve ser um número.',
            'predicted_hour.min' => '"hora prevista" deve ser um número positivo.',
            'predicted_hour.max' => '"hora prevista" deve ser um número válido.',
            
            // Mensagens para o campo 'completed'
            'completed.in' => '"concluído" deve ser 0 (não concluído) ou 1 (concluído).',
            
            // Mensagens para o campo 'real_hour'
            'real_hour.numeric' => '"hora real" deve ser um número.',
            'real_hour.min' => '"hora real" deve ser maior ou igual a 0.',
            'real_hour.max' => '"hora real" deve ser um número válido.',
            'real_hour.required_if' => '"hora real" é obrigatório quando a tarefa está marcada como concluída.',
            ];
    }

}
