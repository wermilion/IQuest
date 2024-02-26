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
        Schema::table('schedule_quests', function (Blueprint $table) {
            $table->dropColumn('time');
            $table->dropColumn('price');
            $table->dropColumn('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_quests', function (Blueprint $table) {
            $table->time('time')->comment('Время');
            $table->decimal('price')->comment('Цена');
            $table->boolean('is_active')->comment('Статус активности');
        });
    }
};
