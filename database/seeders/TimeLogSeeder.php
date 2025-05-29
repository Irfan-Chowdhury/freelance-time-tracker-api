<?php

namespace Database\Seeders;

use App\Models\TimeLog;
use Illuminate\Database\Seeder;

class TimeLogSeeder extends Seeder
{
    // php artisan db:seed --class=TimeLogSeeder

    public function run(): void
    {
        TimeLog::insert([
            [
                'project_id' => 1,
                'start_time' => '2024-01-01 09:00:00',
                'end_time' => '2024-01-01 12:30:00',
                'description' => 'Worked on homepage layout and design.',
                'hours' => 3.5,
                'tags' => json_encode(['billable']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => 1,
                'start_time' => '2024-01-02 14:00:00',
                'end_time' => '2024-01-02 17:00:00',
                'description' => 'Added responsive styling and fixed navbar.',
                'hours' => 3.0,
                'tags' => json_encode(['billable']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => 2,
                'start_time' => '2024-01-03 10:00:00',
                'end_time' => '2024-01-03 13:00:00',
                'description' => 'Set up authentication module.',
                'hours' => 3.0,
                'tags' => json_encode(['billable']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => 2,
                'start_time' => '2024-01-04 15:00:00',
                'end_time' => '2024-01-04 18:30:00',
                'description' => 'Debugged API issues and tested endpoints.',
                'hours' => 3.5,
                'tags' => json_encode(['non-billable']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => 1,
                'start_time' => '2024-01-05 11:00:00',
                'end_time' => '2024-01-05 14:45:00',
                'description' => 'Implemented feedback form and validation.',
                'hours' => 3.75,
                'tags' => json_encode(['billable']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
