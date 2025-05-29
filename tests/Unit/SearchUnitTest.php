<?php

use App\Services\SearchService;
use App\Services\UserService;
use Carbon\Carbon;

beforeEach(function () {
    $this->searchService = new SearchService();
    $this->userService   = new UserService();
});


it('return null data', function () {
    $result = $this->userService->show('12345');
    expect($result)->toBeNull();
});

it('return Vaccine Status : Not registered', function () {
    $result = $this->searchService->getVaccineStatus(false, '2024-10-10');
    expect($result)->toBe('Not registered');
});
it('return Vaccine Status : Not scheduled', function () {
    $result = $this->searchService->getVaccineStatus(true, null);
    expect($result)->toBe('Not scheduled');
});

it('return Vaccine Status : Scheduled', function () {
    $result = $this->searchService->getVaccineStatus(true, Carbon::now()->addDays(1));
    expect($result)->toBe('Scheduled');
});
it('return Vaccine Status : Vaccinated', function () {
    $result = $this->searchService->getVaccineStatus(true, Carbon::now()->subDays(2));
    expect($result)->toBe('Vaccinated');
});










