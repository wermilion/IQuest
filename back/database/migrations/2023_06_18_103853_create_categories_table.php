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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title')
                ->comment('Наименование');
            $table->integer('priority')
                ->nullable()
                ->comment('Приоритет');
            $table->time('weekday_available_start')
                ->nullable()
                ->comment('Время в будни, с которого категория доступна');
            $table->time('weekday_available_end')
                ->nullable()
                ->comment('Время в будни, по которое категория доступна');
            $table->time('weekend_available_start')
                ->nullable()
                ->comment('Время в выходные, с которого категория доступна');
            $table->time('weekend_available_end')
                ->nullable()
                ->comment('Время в выходные, по которое категория доступна');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
