<?php

namespace App\Http\Requests;

use App\Models\Incomming;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['email'],
            'role' => ['between:0,4'],
            'password' => ['nullable'],
        ];
    }
}
