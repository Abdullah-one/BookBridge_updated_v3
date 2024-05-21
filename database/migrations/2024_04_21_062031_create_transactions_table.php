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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bookDonation_id')->constrained('book_donations')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users');
            $table->enum('status',['تم التسليم','تم رفض التبرع','تم استلام التبرع','تم رفض الاستلام']);
            $table->boolean('canCancel')->default(true);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
