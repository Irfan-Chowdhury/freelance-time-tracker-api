<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClientStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->is('api/*') || $this->expectsJson()) {
            throw new HttpResponseException(
                response()->json(['errors' => $validator->errors()], 422)
            );
        }

        parent::failedValidation($validator);  // Use the default behavior for non-API requests
    }


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
