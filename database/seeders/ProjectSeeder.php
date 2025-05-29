<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    // php artisan db:seed --class=ProjectSeeder

    public function run(): void
    {
        Project::insert([
            [
                'client_id' => 1,
                'title' => 'Website Redesign',
                'description' => 'Redesign the entire marketing site for better UX and performance.',
                'status' => 'active',
                'deadline' => now()->addDays(30)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_id' => 2,
                'title' => 'Mobile App Development',
                'description' => 'Develop a cross-platform mobile app for internal communication.',
                'status' => 'completed',
                'deadline' => now()->subDays(10)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
