<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class serSeeder extends Seeder
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
        for($i=11;$i<=20 ;$i++){
            User::create([
                'account_id' => $i,
                'no_donations'=> 1,
            ]);
        }
    }
}
