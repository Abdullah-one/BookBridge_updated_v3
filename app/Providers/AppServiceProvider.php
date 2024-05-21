<?php

namespace App\Providers;

use App\orignalClassOfProvider\phoneNumberFaker;
use Illuminate\Support\ServiceProvider;
use Faker\Factory as FakerFactory;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /*
        $this->app->singleton('Faker\Generator', function () {
            $faker = FakerFactory::create();
            $faker->addProvider(new phoneNumberFaker($faker));
            return $faker;
        });
        */
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
