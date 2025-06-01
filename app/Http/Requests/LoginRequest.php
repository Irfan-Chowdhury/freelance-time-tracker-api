<?php

namespace App\Http\Requests;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    use FailedValidationTrait;

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:5',
        ];
    }
}
