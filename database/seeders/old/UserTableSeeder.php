<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\VaccineService;
use App\Services\SearchService;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        $vaccineService = app(VaccineService::class);
        $searchService = app(SearchService::class);

        User::factory()
            ->count(10)
            ->withServices($vaccineService, $searchService)
            ->create();
    }
}
