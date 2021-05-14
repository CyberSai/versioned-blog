<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/** @version 1 */
class PostStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ];
    }
}
