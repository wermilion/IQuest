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
        Schema::create('lounges', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->comment('Название лаундж-зоны');
            $table->text('description')->comment('Описание лаундж-зоны');
            $table->string('cover')->comment('Обложка');
            $table->integer('max_people')->comment('Максимальное кол-во человек');
            $table->decimal('min_price')->comment('Минимальная цена');
            $table->boolean('is_active')->comment('Статус активности на сайте');

            $table->foreignId('filial_id')->comment('Филиал лаундж-зоны')->constrained(table: 'filials');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lounges');
    }
};
