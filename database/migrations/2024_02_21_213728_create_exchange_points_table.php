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
        Schema::create('exchange_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained('accounts');
            $table->foreignId('residentialQuarter_id')->constrained('residential_quarters');
            $table->unsignedTinyInteger('maxPackages');
            $table->unsignedTinyInteger('no_packages')->default(0);
            $table->string('locationDescription',100)->nullable();
            $table->string('location',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_points');
    }
};
