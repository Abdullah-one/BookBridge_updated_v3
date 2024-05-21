<?php

namespace Database\Seeders;

use App\Models\ResidentialQuarter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResidentialQuarterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        /**
         *you can customize it from factory class of City
         */
        ResidentialQuarter::factory()->custom()->count(10)->create();
    }

}
