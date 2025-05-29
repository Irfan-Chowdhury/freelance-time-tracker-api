<?php

namespace Database\Seeders;

use App\Models\VaccinationSchedule;
use App\Services\VaccinationScheduleService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VaccinationScheduleSeeder extends Seeder
{
    public function run(VaccinationScheduleService $vaccinationScheduleService): void
    {
        VaccinationSchedule::insert($vaccinationScheduleService->schedules());
    }
}
