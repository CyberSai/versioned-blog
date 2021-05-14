<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** @version 1 */
class PostStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category_id' => [Rule::requiredIf($this->route('version') >= 2), 'exists:categories,id'],
        ];
    }
}
