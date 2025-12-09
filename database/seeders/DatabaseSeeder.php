<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Database\Seeders\CountriesTableSeeder;
use Database\Seeders\StatesTableSeeder;
use Database\Seeders\CitiesTableSeeder;
use Database\Seeders\LocationSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        
        $this->call([
            CountriesTableSeeder::class,
            StatesTableSeeder::class,
            CitiesTableSeeder::class,
            LocationSeeder::class
        ]);

        \App\Models\Vehicle::factory(10)->create();
        \App\Models\Customer::factory(10)->create();
        \App\Models\Booking::factory(10)->create(); // Will create associated vehicle/customer
        \App\Models\Payment::factory(10)->create(); // Will create associated booking
    }
}
