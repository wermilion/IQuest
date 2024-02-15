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
        Schema::table('quests', function (Blueprint $table) {
            $table->dropColumn('min_price');
            $table->dropColumn('late_price');
            $table->dropColumn('weekdays');
            $table->dropColumn('weekend');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quests', function (Blueprint $table) {
            $table->float('min_price')->comment('Минимальная цена');
            $table->float('late_price')->comment('Вечерняя цена');
            $table->string('weekdays')->comment('Расписание по будням');
            $table->string('weekend')->comment('Расписание по выходным');
        });
    }
};
