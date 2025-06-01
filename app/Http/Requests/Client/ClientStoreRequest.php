<?php

namespace App\Http\Requests\Client;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
{
    use FailedValidationTrait;

    public function rules(): array
    {
        return [
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:clients,email',
            'gender' => 'required|in:male,female,other',
            'phone'  => 'required|string|max:20',
        ];
    }
}
