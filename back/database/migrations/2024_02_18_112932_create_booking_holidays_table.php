<?php

use App\Domain\Bookings\Models\Booking;
use App\Domain\Holidays\Models\HolidayPackage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_holidays', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignIdFor(Booking::class)->comment('Бронирование')->constrained();
            $table->foreignIdFor(HolidayPackage::class)->comment('Тип праздника и пакет')->constrained();
            $table->unsignedTinyInteger('count_participants')->comment('Количество участников');
            $table->decimal('price')->comment('Цена');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_holidays');
    }
};
