<?php

use App\Domain\Locations\Models\City;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('header')->comment('Заголовок');
            $table->string('description')->comment('Описание');
            $table->string('front_image')->comment('Изображение');
            $table->string('back_image')->comment('Изображение');
            $table->boolean('is_active')->comment('Видимость');

            $table->foreignIdFor(City::class)->comment('Город')->constrained()
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
