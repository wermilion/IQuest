<?php

use App\Domain\Lounges\Models\Lounge;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedule_lounges', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('date')->comment('Дата');
            $table->time('time_from')->comment('Время начада');
            $table->time('time_to')->comment('Время конца');
            $table->foreignIdFor(Lounge::class)->comment('Лаундж-зона')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_lounges');
    }
};
