<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'vaccine_center_id',
        'scheduled_date',
        'users_count',
    ];
}
