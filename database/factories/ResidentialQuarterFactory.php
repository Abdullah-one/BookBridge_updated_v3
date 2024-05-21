<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResidentialQuarter>
 */
class ResidentialQuarterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city_id'=>1,
            'name'=>fake()->randomElement(['الديس','الشرج','المتضررين','الشافعي','خمر','بويش','روكب','الغليلة','الضيافة','الإنشاءات'])
        ];
    }
    /**
     * it is used for further records, other than initial records, you can customize the fields here
     *
     * @return CityFactory|Factory
     */
    public function custom(): CityFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'city_id'=>1,
                'name'=>fake()->unique()->randomElement(['الديس','الشرج','المتضررين','الشافعي','خمر','بويش','روكب','الغليلة','الضيافة','الإنشاءات'])
            ];
        });
    }
}
