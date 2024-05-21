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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name',15);
            $table->enum('district',['أبين','عدن','البيضاء','الحديدة','الجوف',
                'المهرة','المحويت','صنعاء','عمران','ذمار','حضرموت','حجة','إب','لحج','مأرب','ريمة',
                'صعدة','شبوة','أرخبيل سقطرى','تعز']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
