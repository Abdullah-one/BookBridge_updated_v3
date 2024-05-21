<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>fake()->randomElement(['تريم','سيئون','شبام','دوعن','العين','غيل باوزير','حريضة','القطن','الشحر']),
            'district'=>fake()->randomElement(['حضرموت'])
        ];
    }

    /**
     * it is used for further cities, other than initial records, you can customize the fields here
     *
     * @return CityFactory|Factory
     */
    public function custom(): CityFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return[
                'name'=>fake()->unique()->randomElement(['تريم','سيئون','شبام','دوعن','العين','غيل باوزير','حريضة','القطن','الشحر']),
                'district'=>'حضرموت'
            ];
        });
    }

}
