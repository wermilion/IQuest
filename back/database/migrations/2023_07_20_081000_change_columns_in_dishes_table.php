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
        Schema::table('dishes', function (Blueprint $table) {
            $table->bigInteger('price')
                ->unsigned()
                ->comment('Цена')
                ->change();;
            $table->float('calorie')
                ->unsigned()
                ->nullable()
                ->comment('Калории')
                ->change();
            $table->float('proteins')
                ->unsigned()
                ->nullable()
                ->comment('Белки')
                ->change();
            $table->float('fats')
                ->unsigned()
                ->nullable()
                ->comment('Жиры')
                ->change();
            $table->float('carbohydrates')
                ->unsigned()
                ->nullable()
                ->comment('Углеводы')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dishes', function (Blueprint $table) {
            //
        });
    }
};
