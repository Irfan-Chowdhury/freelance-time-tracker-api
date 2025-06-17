<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);


it('can register a user', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'Promi Chowdhury',
        'email' => 'promi@example.com',
        'gender' => 'male',
        'phone' => '01812345678',
        'password' => 'promi',
        'password_confirmation' => 'promi',
    ]);

    // Option-1
    $response->assertStatus(201)
             ->assertJsonStructure([
                 'data' => ['id', 'name', 'email'],
                 'message',
                 'token',
             ]);


    // Option-2
    // $response->assertSuccessful()
    //          ->assertJsonStructure([
    //              'data' => ['id', 'name', 'email'],
    //              'message',
    //              'token',
    //          ]);
});






it('can login a user and access protected route', function () {
    // Create user manually
    $user = User::create([
        'name' => 'Irfan',
        'email' => 'irfan@example.com',
        'gender' => 'male',
        'phone' => '01812345678',
        'password' => Hash::make('password'),
    ]);

    // Try login
    $response = $this->postJson('/api/login', [
        'email' => 'irfan@example.com',
        'password' => 'password',
    ]);

    $response->assertSuccessful()
             ->assertJsonStructure([
                 'data',
                 'message',
                 'token',
             ]);

    $token = $response->json('token');

    // Use token to access protected route
    $profileResponse = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->getJson('/api/profile');

    $profileResponse->assertStatus(200)
                    ->assertJsonStructure([
                        'data' => ['id', 'name', 'email'],
                    ]);
});




it('can logout user', function () {
    $user = User::factory()->create();

    $token = $user->createToken('authToken')->plainTextToken;

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->postJson('/api/logout');

    $response->assertSuccessful()
             ->assertJson([
                 'message' => 'Logged out successfully.',
             ]);
});



// Invalid Login (Wrong Password)


it('cannot login with wrong password', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('correctpassword'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'wrongpassword',
    ]);

    // $response->assertStatus(500)
    //          ->assertJson([
    //              'message' => 'Something is wrong.',
    //          ])
    //          ->assertJsonValidationErrors(['email']);

    $response->assertJson([
        'message' => 'Something went wrong.',
    ]);
});


// Duplicate Registration

it('cannot register with duplicate email', function () {
    $user = User::factory()->create([
        'email' => 'duplicate@example.com',
    ]);

    $response = $this->postJson('/api/register', [
        'name' => 'Duplicate User',
        'email' => 'duplicate@example.com',
        'gender' => 'male',
        'phone' => '01700000000',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);

    $response->assertStatus(422)
             ->assertJsonValidationErrors(['email']);
});


// Access Denied Without Token

it('denies access to protected route without token', function () {
    $response = $this->getJson('/api/profile');

    $response->assertStatus(401)
             ->assertJson([
                 'message' => 'Unauthenticated.',
             ]);
});



