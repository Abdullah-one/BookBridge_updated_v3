<?php

use App\Models\Account;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained('accounts')->cascadeOnDelete();
            $table->unsignedSmallInteger('no_donations')->default(0);
            $table->unsignedSmallInteger('no_benefits')->default(0);
            $table->unsignedTinyInteger('no_bookingOfFirstSemester')->default(0);
            $table->unsignedTinyInteger('no_bookingOfSecondSemester')->default(0);
            $table->unsignedSmallInteger('no_non_adherence_donor')->default(0);
            $table->unsignedSmallInteger('no_non_adherence_beneficiary')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
