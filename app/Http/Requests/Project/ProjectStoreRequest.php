<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProjectStoreRequest extends FormRequest
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
            'client_id'   => 'required|exists:clients,id',
            'title'       => 'required|string|max:255|unique:projects,title',
            'description' => 'nullable|string',
            'status'      => 'in:active,completed',
            'deadline'    => 'nullable|date',
        ];
    }
}
