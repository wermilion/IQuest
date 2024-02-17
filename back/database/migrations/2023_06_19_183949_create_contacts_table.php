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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('phone')
                ->nullable()
                ->comment('Контактный номер теефона');
            $table->string('email')
                ->nullable()
                ->comment('Контактная электронная почта');
            $table->string('vk')
                ->nullable()
                ->comment('Ссылка на группу ВК');
            $table->string('whatsapp')
                ->nullable()
                ->comment('Ссылка на Whatsapp');
            $table->string('gis')
                ->nullable()
                ->comment('Ссылка на заведение в 2gis');
            $table->string('address')
                ->nullable()
                ->comment('Адрес заведения');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
