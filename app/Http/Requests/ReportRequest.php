<?php

namespace App\Http\Requests;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    use FailedValidationTrait;

    public function rules(): array
    {
        return [
            'client_id' => 'nullable|exists:clients,id',
            'project_id' => 'nullable|exists:projects,id',
            'from' => 'nullable|date',
            'to' => 'nullable|date|after_or_equal:from',
        ];
    }
}
