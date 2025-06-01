<?php

namespace App\Http\Requests\Project;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
{
    use FailedValidationTrait;

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
