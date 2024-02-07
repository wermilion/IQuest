<?php

use App\Domain\Quests\Models\Quest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedule_quests', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('date')->comment('Дата');
            $table->time('time')->comment('Время');
            $table->boolean('activity_status')->comment('Статус активности в расписании');
            $table->foreignIdFor(Quest::class)->comment('Квест')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_quests');
    }
};
