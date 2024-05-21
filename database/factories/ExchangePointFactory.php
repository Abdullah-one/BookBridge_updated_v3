<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExchangePoint>
 */
class ExchangePointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'residentialQuarter_id'=>fake()->numberBetween(1,10),
            'maxPackages'=>fake()->numberBetween(10,50),
            'location'=>fake()->randomElement(['https://maps.app.goo.gl/GdtGVs9vjt9yMxsH8','https://maps.app.goo.gl/ayuuKA7F2rcBo95Y9',
                'https://maps.app.goo.gl/ifWmzHfvSQvzkMyu5']),
            'locationDescription'=>fake()->text(50)
        ];
    }
}
