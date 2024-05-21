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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('userName',40)->unique();
            $table->string('phoneNumber',9)->index()->nullable();
            $table->boolean('emailVerified')->default(false);
            $table->boolean('phoneVerified')->default(false);
            $table->string('fcm_token')->nullable();
            /*
            'exist' column used to check if  there was  an account with the same phone number in specific duration,
            the value 1 means there was one account,
            the value 2 means there was more than one account,
            1,2 only the acceptable values,
            the goal of this field to provide support for app polices and security, preventing
            illegal and unethical use of app by reselling the books
            */
            $table->boolean('exist')->default(false);
            $table->string('password');
            $table->string('email');
            $table->enum('role',['user','point','admin']);
            $table->rememberToken();
            $table->softDeletes();
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
