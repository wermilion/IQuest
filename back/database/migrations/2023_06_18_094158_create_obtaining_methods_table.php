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
        Schema::create('obtaining_methods', function (Blueprint $table) {
            $table->id();
            $table->string('title')
                ->comment('Способ получения заказа');
            $table->integer('price')
                ->comment('Стоимость получения заказа');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obtaining_methods');
    }
};
