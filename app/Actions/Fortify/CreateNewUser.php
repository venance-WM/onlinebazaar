<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Validation\Rule;
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
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'phone' => $input['phone'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
