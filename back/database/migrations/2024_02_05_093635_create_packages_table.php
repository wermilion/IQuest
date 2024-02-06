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
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->comment('Название пакета');
            $table->string('description')->comment('Описание пакета');
            $table->unsignedInteger('price')->comment('Цена пакета');
            $table->unsignedInteger('min_people')->comment('Минимальное количество людей');
            $table->unsignedInteger('max_people')->comment('Максимальное количество людей');
            $table->boolean('is_active')->comment('Активность пакетa');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
