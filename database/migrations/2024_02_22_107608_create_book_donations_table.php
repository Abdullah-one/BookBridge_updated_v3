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
        Schema::create('book_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained('users');
            $table->foreignId('exchangePoint_id')->nullable()->constrained('exchange_points');
            $table->enum('level',['أولى إعدادي','ثاني إعدادي','ثالث إعدادي','رابع إعدادي','خامس إعدادي','سادس إعدادي',
                'سابع إعدادي','ثامن إعدادي','تاسع إعدادي','أولى ثانوي','ثاني ثانوي','ثالث ثانوي']);
            $table->enum('semester',['الفصل الأول','الفصل الثاني','كلا الفصلين']);
            $table->enum('status',['غير محجوز وليس في النقطة','محجوز في انتظار الاستلام','غير محجوز في النقطة'
            ,'محجوز في انتظار التسليم','تم التسليم','تم الحذف من النقطة',' تم الحذف من المدير','تم رفض التبرع'])
                ->default('غير محجوز وليس في النقطة');
            $table->boolean('canAcceptEvenItIsNotWaited')->default(false);
            $table->boolean('isHided')->default(false);
            $table->string('description',1000)->nullable();
            $table->dateTime('receiptDate')->nullable();
            $table->dateTime('startLeadTimeDateForDonor')->nullable();
            $table->boolean('isRemovable')->default(false);
            $table->unsignedTinyInteger('no_rejecting')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_donations');
    }
};
