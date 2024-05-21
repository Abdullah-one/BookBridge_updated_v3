<?php

namespace App\orignalClassOfProvider;

use Faker\Provider\Base;

class phoneNumberFaker extends Base
{

    public function randomPhoneNumber()
    {
        $prefixes = ['77', '78', '73', '71', '70'];
        $prefix = $this->randomElement($prefixes);
        $randomNumber = mt_rand(1000000, 9999999); // Generate a random 7-digit number

        return $prefix . $randomNumber;
    }
}
