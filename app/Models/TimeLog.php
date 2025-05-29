<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'start_time',
        'end_time',
        'description',
        'hours',
        'tags', // For bonus: billable/non-billable
    ];
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'tags' => 'array', // Assuming tags are stored as a JSON array
    ];
    protected $attributes = [
        'hours' => 0.00, // Default value for hours
    ];
}
