<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use App\Models\BookDonation;
use App\Models\Chat;
use App\Models\City;
use App\Models\ExchangePoint;
use App\Models\ResidentialQuarter;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * create mukalla city
         */
        City::create([
            'name'=>'المكلا',
            'district'=>'حضرموت'
        ]);

        /**
         * seeder of City
         */
        City::factory()->count(9)->create();

        /**
         * seeder of ResidentialQuarter
         */
        ResidentialQuarter::factory()->count(10)->create();

        /**
         * seeder of account
         */
        Account::factory()->user()
            ->count(10)
            ->create();

        for($i=1;$i<=10 ;$i++){
            User::create([
                'account_id' => $i,
            ]);
        }


        Account::factory()->point()
            ->count(10)
            ->create();

        for($i=11;$i<=20 ;$i++) {
            ExchangePoint::factory()->create([
                'account_id'=>$i
            ]);
        }

        /**
         * seeder of bookDonation
         */
        $allIdentifierOfUser=User::pluck('id');
        foreach($allIdentifierOfUser as $id) {
            BookDonation::factory()->create([
                'donor_id'=>$id
            ]);
        }
    }
}
