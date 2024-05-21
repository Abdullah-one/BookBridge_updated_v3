<?php

namespace Database\Factories;

use App\orignalClassOfProvider\phoneNumberFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\account>
 */
class AccountFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new phoneNumberFaker($faker));
        return [
            'userName' => fake()->unique()->firstName(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'phoneNumber'=>$faker->randomPhoneNumber(),
            'email'=>fake()->email(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
    /**
     * it is used for further account of type admin, other than initial records, you can customize the fields here
     *
     * @return AccountFactory|Factory
     */
    public function admin(): AccountFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return[
                'role'=>'admin'
            ];
        });
    }
    /**
     * it is used for further accounts of type point, other than initial records, you can customize the fields here
     *
     * @return AccountFactory|Factory
     */
    public function point(): AccountFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return[
                'role'=>'point'
            ];
        });
    }
    /**
     * it is used for further accounts of type User, other than initial records, you can customize the fields here
     *
     * @return AccountFactory|Factory
     */
    public function user(): AccountFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return[
                'role'=>'User'
            ];
        });
    }
}
