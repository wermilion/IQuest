<?php

use App\Domain\Bookings\Models\Booking;
use App\Domain\Schedules\Models\ScheduleLounge;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_schedule_lounges', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignIdFor(Booking::class)->comment('Идентификатор бронирования')->constrained()
                ->onDelete('cascade');
            $table->foreignIdFor(ScheduleLounge::class)->comment('Идентификатор лаунжа')->constrained()
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_schedule_lounges');
    }
};
