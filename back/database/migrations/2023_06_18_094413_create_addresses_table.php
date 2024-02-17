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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('city')
                ->comment('Город');
            $table->string('street')
                ->comment('Улица');
            $table->string('house')
                ->comment('Дом');
            $table->string('flat')
                ->nullable()
                ->comment('Квартира');
            $table->string('entrance')
                ->nullable()
                ->comment('Подъезд');
            $table->string('floor')
                ->nullable()
                ->comment('Этаж');
            $table->string('intercom')
                ->nullable()
                ->comment('Домофон');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add2resses');
    }
};
