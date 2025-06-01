<?php

namespace App\Http\Requests\TimeLog;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class TimeLogStoreRequest extends FormRequest
{
    use FailedValidationTrait;

    public function rules(): array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'description' => 'nullable|string',
            'tags' => 'nullable|array',
            // 'tags.*' => 'in:billable,non-billable,client-meeting,personal,admin',
        ];
    }
}
