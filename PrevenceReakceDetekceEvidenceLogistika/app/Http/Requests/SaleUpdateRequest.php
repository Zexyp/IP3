<?php

namespace App\Http\Requests;

use App\Models\Incomming;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaleUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['date'],
            'mass' => ['numeric'],
            'worth' => ['numeric'],
        ];
    }
}
