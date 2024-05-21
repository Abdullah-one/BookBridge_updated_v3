<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         *create accounts of type User and point
            Account::factory()
            ->count(10)
            ->create();
         * /

        /**
         * creat accounts of type admin
            Account::factory()->admin()->count(10)->create();
         */

        /**
         * creat accounts of type point*/
             Account::factory()->point()->count(10)->create();


        /**
         * creat accounts of type User
            Account::factory()->User()->count(10)->create();
         */

    }
}
