<?php

namespace Database\Factories;

use App\Models\User;
use App\Services\VaccineService;
use App\Services\SearchService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;
    protected VaccineService $vaccineService;
    protected SearchService $searchService;

    public function withServices(VaccineService $vaccineService, SearchService $searchService): self
    {
        $this->vaccineService = $vaccineService;
        $this->searchService = $searchService;

        return $this;
    }

    public function definition(): array
    {
        $genders = ['male', 'female', 'other'];
        $getScheduledDate = self::getScheduledDate();
        return [
                'name' => fake()->name(),
                'gender' => $genders[array_rand($genders)],
                'email' => fake()->unique()->safeEmail(),
                'date_of_birth' => $this->getDateOfBirth(),
                'nid' => fake()->numberBetween($min = 1000000000, $max = 9000000000),
                'address' => fake()->address,
                'phone' => '8801' . str_pad(rand(0, 999999), 9, '0', STR_PAD_LEFT),
                'vaccine_status' => $this->searchService->getVaccineStatus(true,$getScheduledDate),
                'vaccine_center_id' => fake()->numberBetween($min = 1, $max = 10),
                'scheduled_date' => $getScheduledDate,
                'created_at' => now(),
                'updated_at' => now(),
        ];
    }

    protected function getDateOfBirth()
    {
        $startDate = strtotime('-80 years');
        $endDate = strtotime('-18 years');

        $randomTimestamp = rand($startDate, $endDate);

        return date('Y-m-d', $randomTimestamp);
    }

    public function getScheduledDate(): string
    {
        $date =  Carbon::today()
            ->addDays(rand(-15, 30))
            ->format('Y-m-d');

        return $this->vaccineService->getNextAvailableDate($date);
    }


}
