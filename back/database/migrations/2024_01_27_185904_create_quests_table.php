<?php

use App\Models\AgeLimit;
use App\Models\Filial;
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
            $table->string('slug')->comment('Сокращенное имя квеста');
            $table->text('description')->comment('Описание квеста');
            $table->string('cover')->comment('Обложка квеста');
            $table->decimal('min_price')->comment('Минимальная цена квеста');
            $table->decimal('late_price')->comment('Цена для ночного посещения квеста');
            $table->integer('min_people')->comment('Минимальное кол-во людей');
            $table->integer('max_people')->comment('Максимальное кол-во людей');
            $table->integer('duration')->comment('Продолжительность квеста');
            $table->boolean('can_add_time')->comment('Можно ли добавить время');
            $table->boolean('is_active')->comment('Статус активности отображения на сайте');
            $table->integer('sequence_number')->comment('Порядковый номер квеста');
            $table->string('weekdays')->comment('Расписание по будням');
            $table->string('weekend')->comment('Расписание по выходным');

            $table->foreignIdFor(Room::class)->comment('Адрес квеста')->constrained();
            $table->foreignIdFor(Type::class)->comment('Тип квеста')->constrained();
            $table->foreignIdFor(Genre::class)->comment('Жанр квеста')->constrained();
            $table->foreignIdFor(AgeLimit::class)->comment('Возрастное ограничение квеста')->constrained();
            $table->foreignIdFor(Level::class)->comment('Уровень сложности квеста')->constrained();

            $table->timestamps();
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
