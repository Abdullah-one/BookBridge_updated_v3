<?php

namespace Database\Seeders;

use App\Models\ExchangePoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookDonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * edit $i to allocate new added User, every User must have one donation maintain the reality
         */
        for($i=1;$i<=10 ;$i++) {
            ExchangePoint::factory()->count(10)->create([
                'donor_id' => $i]);
        }
    }

    /**
     *to add BookDonation exit in a point and was not booked
        for($i=1;$i<=10 ;$i++) {
        ExchangePoint::factory()->inPoint()->count(10)->create([
        'donor_id' => $i]);
        }
     */
}
