<?php

namespace App\Http\Requests;

use App\Constants\UserRoles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
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
        $clientId = $this->route('id');
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('clients', 'name')->ignore($clientId),
            ], 
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('clients', 'email')->ignore($clientId),
            ],
            'address' => 'required|string|max:255',
            'phone' =>[
                'required',
                'string',
                'max:15',
                'min:15',
                'regex:/^\(\d{2}\) \d{5}-\d{4}$/', // Validação do formato (XX) XXXXX-XXXX
            ],
            'type' => 'required|in:0,1',
            'cpfCnpj' => [
                'required',
                'string',
                Rule::unique('clients', 'cpfCnpj')->ignore($clientId),
                'regex:/^(\d{3}\.\d{3}\.\d{3}-\d{2}|\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2})$/'
            ],
        ];
    }

    public function messages()
    {
        $cpfCnpjType = $this->all()['type'] ? 'CNPJ' : 'CPF';
        return  [
            // Mensagens para o campo 'name'
            'name.required' => 'O campo "nome" é obrigatório.',
            'name.string' => 'O campo "nome" deve ser um texto.',
            'name.max' => 'Insira um nome menor.',
            'name.unique' => 'Já existe um cliente cadastrado com este nome.',
    
            // Mensagens para o campo 'email'
            'email.required' => 'O campo "email" é obrigatório.',
            'email.email' => 'Insira um endereço de email válido.',
            'email.max' => 'O campo "email" deve ter no máximo 100 caracteres.',
            'email.unique' => 'Já existe um cliente cadastrado com este email.',
    
            // Mensagens para o campo 'address'
            'address.required' => '"endereço" é obrigatório.',
            'address.string' => '"endereço" deve ser um texto.',
            'address.max' => 'Insira um endereço menor.',
    
            // Mensagens para o campo 'phone'
            'phone.required' => '"telefone" é obrigatório.',
            'phone.string' => 'Insira um telefone no formato (xx) xxxxx-xxxx.',
            'phone.max' => 'Insira um telefone no formato (xx) xxxxx-xxxx.',
            'phone.min' => 'Insira um telefone no formato (xx) xxxxx-xxxx.',
            'phone.regex' => 'Insira um telefone no formato (xx) xxxxx-xxxx.',
    
            // Mensagens para o campo 'type'
            'type.required' => 'O campo "tipo" é obrigatório.',
            'type.in' => 'O campo "tipo" deve ser CPF ou CNPJ.',
    
            // Mensagens para o campo 'cpfCnpj'
            'cpfCnpj.required' => 'O campo "CPF/CNPJ" é obrigatório.',
            'cpfCnpj.string' => 'Insira um ' . $cpfCnpjType . ' no formato correto.',
            'cpfCnpj.unique' => 'Já existe um cliente cadastrado com este ' . $cpfCnpjType,
            'cpfCnpj.regex' => 'Insira um ' . $cpfCnpjType . ' no formato correto.',
        ];
    }
}