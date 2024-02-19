<?php

use App\Domain\Holidays\Models\Holiday;
use App\Domain\Holidays\Models\Package;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('holiday_packages', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignIdFor(Holiday::class)->comment('Праздник')->constrained();
            $table->foreignIdFor(Package::class)->comment('Пакет')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holiday_packages');
    }
};
