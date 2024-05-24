<?php

namespace Database\Seeders;

use App\Models\BookDonation;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imagesSources=[
            'http://localhost:8000/storage/images/17165241448.jpg',
            'http://localhost:8000/storage/images/17165242205.jpg',
            'http://localhost:8000/storage/images/17165243169.jpg'
        ];
        for($i=2;$i<=29;$i++){
            for($j=0;$j<=2;$j++) {
                Image::create([
                    'bookDonation_id' => $i,
                    'source'=>$imagesSources[$j]
                ]);
            }
        }
    }
}
