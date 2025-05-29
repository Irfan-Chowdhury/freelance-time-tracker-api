<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    // php artisan db:seed --class=ClientSeeder

    public function run(): void
    {
        Client::insert([
            [
                'name' => 'Acme Corp',
                'email' => 'client1@acme.com',
                'gender' => 'female',
                'phone' => '01711223344',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Beta Solutions',
                'email' => 'client2@beta.com',
                'gender' => 'male',
                'phone' => '01855667788',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
