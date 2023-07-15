<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $carBrands = ['TESLA', 'TOYOTA', 'BMW', 'OPEL', 'HONDA', 'CHEVROLET'];

        $carModels = ['Sedan' , 'Hatchback', 'SUV', 'Crossover', 'Convertible','Minivan'];


        $randomBrands = $this->faker->randomElement($carBrands);
        $randomModels = $this->faker->randomElement($carModels);


        return [
            'brand' => $randomBrands,
            'model' => $randomModels,
            'year' => $this->faker->numberBetween(2005, date('Y')),
            'daily_price' => $this->faker->numberBetween(10, 100),
            'image' => fake()->imageUrl(),
            'document' =>fake()->imageUrl(),
            'image_name' => fake()->firstName(),
            'document_name' => fake()->firstName()
        ];
    }
}
