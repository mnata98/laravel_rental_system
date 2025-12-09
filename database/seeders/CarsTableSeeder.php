<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;

class CarsTableSeeder extends Seeder
{
    public function run()
    {
        $cars = [
            [
                'brand' => 'Toyota',
                'model' => 'Camry',
                'year' => 2023,
                'plate_number' => 'ABC-1234',
                'type' => 'Sedan',
                'daily_rate' => 50.00,
                'status' => 'available',
                'description' => 'Comfortable and reliable sedan perfect for business trips or family outings.',
            ],
            [
                'brand' => 'Honda',
                'model' => 'CR-V',
                'year' => 2023,
                'plate_number' => 'XYZ-5678',
                'type' => 'SUV',
                'daily_rate' => 75.00,
                'status' => 'available',
                'description' => 'Spacious SUV with excellent fuel economy and advanced safety features.',
            ],
            [
                'brand' => 'BMW',
                'model' => '5 Series',
                'year' => 2024,
                'plate_number' => 'LUX-9999',
                'type' => 'Luxury',
                'daily_rate' => 150.00,
                'status' => 'available',
                'description' => 'Premium luxury sedan with cutting-edge technology and superior comfort.',
            ],
            [
                'brand' => 'Ford',
                'model' => 'F-150',
                'year' => 2023,
                'plate_number' => 'TRK-4567',
                'type' => 'Truck',
                'daily_rate' => 85.00,
                'status' => 'available',
                'description' => 'Powerful pickup truck ideal for hauling and outdoor adventures.',
            ],
            [
                'brand' => 'Mercedes-Benz',
                'model' => 'E-Class',
                'year' => 2024,
                'plate_number' => 'MBZ-7890',
                'type' => 'Luxury',
                'daily_rate' => 180.00,
                'status' => 'available',
                'description' => 'Elegant luxury sedan combining performance with sophisticated design.',
            ],
            [
                'brand' => 'Nissan',
                'model' => 'Altima',
                'year' => 2022,
                'plate_number' => 'NIS-3456',
                'type' => 'Sedan',
                'daily_rate' => 45.00,
                'status' => 'available',
                'description' => 'Affordable and efficient sedan perfect for daily commuting.',
            ],
        ];

        foreach ($cars as $carData) {
            Car::create($carData);
        }
    }
}
