<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    // php artisan db:seed --class=UserSeeder

    public function run(): void
    {
        User::create([
            'name' => 'Irfan Chowdhury',
            'email' => 'admin@gmai.com',
            'gender' => 'male',
            'phone' => '018294998634',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
        ]);
    }
}
