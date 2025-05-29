<?php

namespace Database\Seeders;

use App\Models\VaccineCenter;
use Illuminate\Database\Seeder;

class VaccineCenterSeeder extends Seeder
{
    public function run(): void
    {
        VaccineCenter::factory()
            ->count(10)
            ->create();
    }
}
