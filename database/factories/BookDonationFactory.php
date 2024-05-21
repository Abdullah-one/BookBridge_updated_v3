<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookDonation>
 */
class BookDonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'exchangePoint_id'=>fake()->unique()->numberBetween(1,10),
            'level'=>fake()->randomElement(['أولى إعدادي','ثاني إعدادي','ثالث إعدادي','رابع إعدادي','خامس إعدادي','سادس إعدادي',
                'سابع إعدادي','ثامن إعدادي','تاسع إعدادي','أولى ثانوي','ثاني ثانوي','ثالث ثانوي']),
            'semester'=>fake()->randomElement(['الفصل الأول','الفصل الثاني','كلا الفصلين']),
            'description'=>fake()->text(200)
        ];
    }
    /**
     * it is used for  BookDonation exit directly from point
     *
     * @return BookDonationFactory|Factory
     */
    public function inPoint(): BookDonationFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status'=>'غير محجوز في النقطة',
                'receiptDate'=>fake()->dateTime()
            ];
        });
    }
}
