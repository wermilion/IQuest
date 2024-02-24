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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->comment('Роль пользователя');
            $table->foreignId('filial_id')->nullable()->comment('Филиал')->constrained(table: 'filials')
                ->nullOnDelete();
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
            $table->dropColumn('vk_id');

            $table->dropForeign('filial_id');
            $table->dropColumn('filial_id');
        });
    }
};
