<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\BookDonation;
use App\Models\City;
use App\Models\ExchangePoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class deleteAllRecords_general extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::query()->delete();
        //
    }
}
