<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('booking_holidays', function (Blueprint $table) {
            $table->dropColumn(['count_participants', 'price']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_holidays', function (Blueprint $table) {
            $table->unsignedTinyInteger('count_participants')->comment('Количество участников')->nullable();
            $table->decimal('price')->comment('Цена')->nullable();
        });
    }
};
