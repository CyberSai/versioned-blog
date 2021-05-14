<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

/** @version 1 */
class UserStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'api_token' => ['required', 'string', 'size:200'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'api_token' => Str::random(200),
        ]);
    }

    public function validated()
    {
        $validated = parent::validated();
        $validated['password'] = bcrypt($validated['password']);
        return $validated;
    }
}
