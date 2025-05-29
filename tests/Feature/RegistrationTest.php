<?php

use App\Models\User;

test('Registration Http Check', function () {

    $response = $this->get('/registration');
    $this->get(route('registration'))->assertOk();
    $response->assertStatus(200);
});


test('Registration correct view', function() {
    $this->get(route('registration'))
        ->assertOk()
        ->assertViewIs('pages.registration.create');
});

/*
|--------------------------------------------------------------------------
| During Store
|--------------------------------------------------------------------------
|
*/

// Validation
test('requires the name', function () {
    // $this->withoutExceptionHandling();
    $this->post(route('registration'), array_merge(userData(), ['name' =>'']))
        ->assertInvalid(['name' => 'required']);
});

test('string the name', function () {
    $this->post(route('registration'), array_merge(userData(), ['name' =>123456]))
    ->assertSessionHasErrors('name');
});

test('email the required', function () {
    $this->post(route('registration'), array_merge(userData(), ['email' =>'']))
    ->assertSessionHasErrors('email');
});
test('phone the required', function () {
    $this->post(route('registration'), array_merge(userData(), ['phone' =>'']))
    ->assertSessionHasErrors('phone');
});
test('phone must be numeric', function () {
    $this->post(route('registration'), array_merge(userData(), ['phone' =>'ABCDF']))
    ->assertSessionHasErrors('phone');
});
test('gender must be required', function () {
    $this->post(route('registration'), array_merge(userData(), ['gender' =>'']))
    ->assertSessionHasErrors('gender');
});
test('date_of_birth must be required', function () {
    $this->post(route('registration'), array_merge(userData(), ['date_of_birth' =>'']))
    ->assertSessionHasErrors('date_of_birth');
});
test('nid must be required', function () {
    $this->post(route('registration'), array_merge(userData(), ['nid' =>'']))
    ->assertSessionHasErrors('nid');
});
test('nid must be numeric', function () {
    $this->post(route('registration'), array_merge(userData(), ['nid' =>'ABBC343242']))
    ->assertSessionHasErrors('nid');
});
test('address must be required', function () {
    $this->post(route('registration'), array_merge(userData(), ['address' =>'']))
    ->assertSessionHasErrors('address');
});
test('vaccine_center_id must be required', function () {
    $this->post(route('registration'), array_merge(userData(), ['vaccine_center_id' =>'']))
    ->assertSessionHasErrors('vaccine_center_id');
});




