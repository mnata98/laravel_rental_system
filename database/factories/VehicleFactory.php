<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $brands = ['Toyota', 'Honda', 'Perodua', 'Proton', 'BMW', 'Mercedes', 'Ford'];
        $models = ['Camry', 'Civic', 'Myvi', 'Saga', 'X5', 'C200', 'Ranger'];
        
        return [
            'name' => $this->faker->randomElement($brands) . ' ' . $this->faker->randomElement($models),
            'plate_number' => strtoupper($this->faker->bothify('???####')),
            'daily_rate' => $this->faker->randomFloat(2, 50, 500),
            'status' => $this->faker->randomElement(['available', 'unavailable']),
            'image' => null, 
        ];
    }
}
