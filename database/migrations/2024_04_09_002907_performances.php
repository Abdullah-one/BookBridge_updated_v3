<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exchangePoint_id')->constrained("exchange_points")->cascadeOnDelete();
            $table->enum('month',[1,2,3,4,5,6,7,8,9,10,11,12]);
            $table->smallInteger('year');
            $table->integer('no_addedDonation')->default(0);
            $table->integer('no_bookedDonation')->default(0);
            $table->integer('no_canceledDonationFromDonor')->default(0);
            $table->integer('no_canceledDonationFromBeneficiary')->default(0);
            $table->integer('no_receivedDonation')->default(0);
            $table->integer('no_removedDonationByAdmin')->default(0);
            $table->integer('no_removedDonation')->default(0);
            $table->integer('no_rejectedDonation')->default(0);
            $table->integer('no_deliveredDonation')->default(0);
            $table->integer('no_rejectedDonationFromBeneficiary')->default(0);
            $table->integer('no_reachingMaxPackages')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performances');
    }
};
