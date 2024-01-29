<?php

use App\Models\AgeLimit;
use App\Models\Genre;
use App\Models\Level;
use App\Models\Room;
use App\Models\Type;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quests', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->comment('Название квеста');
            $table->string('name_slug')->comment('Сокращенное имя квеста');
            $table->text('desc')->comment('Описание квеста');
            $table->string('cover')->comment('Обложка квеста');
            $table->decimal('min_price')->comment('Минимальная цена квеста');
            $table->decimal('late_price')->comment('Цена для ночного посещения квеста');
            $table->integer('min_people')->comment('Минимальное кол-во людей');
            $table->integer('max_people')->comment('Максимальное кол-во людей');
            $table->integer('duration')->comment('Продолжительность квеста');
            $table->boolean('add_time')->comment('Можно ли добавить время');
            $table->integer('sequence_number')->comment('Порядковый номер квеста');

            $table->foreignIdFor(Room::class)->comment('Адрес квеста')->constrained();
            $table->foreignIdFor(Type::class)->comment('Тип квеста')->constrained();
            $table->foreignIdFor(Genre::class)->comment('Жанр квеста')->constrained();
            $table->foreignIdFor(AgeLimit::class)->comment('Возрастное ограничение квеста')->constrained();
            $table->foreignIdFor(Level::class)->comment('Уровень сложности квеста')->constrained();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quests');
    }
};
