<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait FailedValidationTrait
{
    public function authorize(): bool
    {
        return true;
    }

    protected function FailedValidationTrait(Validator $validator)
    {
        if ($this->is('api/*') || $this->expectsJson()) {
            throw new HttpResponseException(
                response()->json(['errors' => $validator->errors()], 422)
            );
        }

        parent::FailedValidationTrait($validator);
    }
}