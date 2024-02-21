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
        Schema::table('quests', function (Blueprint $table) {
            $table->string('cover')->nullable()->change();
        });

        Schema::table('lounges', function (Blueprint $table) {
            $table->string('cover')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quests', function (Blueprint $table) {
            $table->string('cover')->nullable(false)->change();
        });

        Schema::table('lounges', function (Blueprint $table) {
            $table->string('cover')->nullable(false)->change();
        });
    }
};
