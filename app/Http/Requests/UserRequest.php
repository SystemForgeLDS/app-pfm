<?php

namespace App\Http\Requests;

use App\Actions\Fortify\PasswordValidationRules;
use App\Constants\UserRoles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    use PasswordValidationRules;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->user()->type == UserRoles::PARTNER) 
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
        $userId = $this->route('id');

        // Apenas exige a senha se for uma criação
        $rolePass = $userId ? 'nullable' : 'required';

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('users', 'name')->ignore($userId),
            ], 
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'value_hour' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:0',
            'type' => 'required|in:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT.','.UserRoles::FINANCIER.','.UserRoles::INTERN.',',
            'password' => [
                $rolePass,
                'string',
                'min:8',
            ],
        ];
    }
}
