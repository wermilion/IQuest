<?php

use App\Models\Lounge;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lounge_images', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('image')->comment('Путь к картинке');
            $table->foreignIdFor(Lounge::class)->comment('Лаундж')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lounge_images');
    }
};
