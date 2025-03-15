<?php

namespace App\Actions\Fortify;

use App\Constants\UserRoles;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'type' => ['required', 'required|in:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT.','.UserRoles::FINANCIER.','.UserRoles::INTERN],
            'value_hour' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', 'min:0'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'type' => $input['type'],
            'value_hour' => $input['value_hour'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
