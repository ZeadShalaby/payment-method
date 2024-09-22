<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Offers;
use App\Models\Orders;
use App\Models\Payments;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ?todo add 10 users 
        User::factory()->count(10)->create();

        // ?todo add 10 users 
        Offers::factory()->count(10)->create();

        // ?todo add 10 users 
        Orders::factory()->count(10)->create();

        // ?todo add 10 users 
        Payments::factory()->count(10)->create();

    }
}
