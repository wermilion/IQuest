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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->comment('Роль пользователя');
            $table->foreignIdFor(Filial::class)->nullable()->comment('Филиал')->constrained();
            $table->string('vk_id')->nullable()->unique()->comment('ID ВКонтакте');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');

            $table->dropForeign(['filial_id']);
            $table->dropColumn('filial_id');

            $table->dropColumn('vk_id');
        });
    }
};
