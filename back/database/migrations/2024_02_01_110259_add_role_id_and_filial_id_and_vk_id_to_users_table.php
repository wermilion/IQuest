<?php

use App\Models\Filial;
use App\Models\Role;
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
            $table->foreignIdFor(Role::class)->comment('Роль')->constrained();
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
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');

            $table->dropForeign(['filial_id']);
            $table->dropColumn('filial_id');

            $table->dropColumn('vk_id');
        });
    }
};
