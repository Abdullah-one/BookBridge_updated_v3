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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('bookDonation_id')->constrained('book_donations')->cascadeOnDelete();
            $table->boolean('activeOrSuccess')->default(false);
            $table->dateTime('deliveryDate')->nullable();
            $table->unsignedSmallInteger('code')->nullable();
            $table->dateTime('startLeadTimeDateForBeneficiary')->nullable();
            $table->enum('status',['تم التسليم','بانتظار استلامها من المتبرع','بانتظار مجيئك واستلامها',
                'تم إلغاء الحجز من المتبرع','المتبرع لم يسلم حزمة الكتب','المستفيد لم يستلم حزمة الكتب'
                , 'تم إلغاء الحجز من البرنامج','تم إلغاء الحجز من المستفيد','المستفيد لم يقبل حزمة الكتب'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
