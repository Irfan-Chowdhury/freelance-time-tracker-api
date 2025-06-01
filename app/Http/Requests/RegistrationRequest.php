<?php

namespace App\Http\Requests;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    use FailedValidationTrait;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'gender' => 'required|string|max:10',
            'phone' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ];
    }
}
