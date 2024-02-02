<?php

use App\Models\Filial;
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

            $table->foreignIdFor(Filial::class)->comment('Филиал лаундж-зоны')->constrained();

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
