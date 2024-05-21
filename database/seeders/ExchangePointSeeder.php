<?php

namespace Database\Seeders;

use App\Models\ExchangePoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExchangePointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * edit the initial of $i and the right number of condition
         * to fill empty accounts
         */
        for($i=1;$i<=10 ;$i++) {
            ExchangePoint::factory()->count(10)->create([
                'account_id'=>$i
                /**
                 * if you want to increase the range of residentialQuarter if a new
                 * records in it inserted, other than initial records
                    'residentialQuarter_id'=>fake()->numberBetween(1,10),
                 */
            ]);
        }
    }
}
