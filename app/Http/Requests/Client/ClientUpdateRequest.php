<?php

namespace App\Http\Requests\Client;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
{
    use FailedValidationTrait;

    public function rules(): array
    {
        return [
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:clients,email,' . $this->route('client')->id, //api/clients/{client}
            'gender' => 'required|in:male,female,other',
            'phone'  => 'required|string|max:20',
        ];
    }
}
