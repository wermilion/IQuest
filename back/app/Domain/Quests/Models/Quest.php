<?php

namespace App\Domain\Quests\Models;

use App\Domain\Locations\Models\Filial;
use App\Domain\Locations\Models\Room;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Facades\Storage;

/**
 * Class Quest
 *
 * @property int $id - Идентификатор квеста
 * @property string $name - Название квеста
 * @property string $slug - Сокращенное название квеста
 * @property string $description - Описание квеста
 * @property string $cover - Обложка квеста
 * @property float $min_price - Минимальная цена
 * @property float $late_price - Вечерняя цена
 * @property int $min_people - Минимальное количество участников
 * @property int $max_people - Максимальное количество участников
 * @property int $duration - Продолжительность
 * @property bool $can_add_time - Можно ли добавлять дополнительное время
 * @property bool $is_active - Активность на клиентской части
 * @property int $sequence_number - Порядковый номер
 * @property array $weekdays - Расписание по будням
 * @property array $weekend - Расписание по выходным
 * @property int $room_id - Идентификатор комнаты
 * @property int $type_id - Идентификатор типа
 * @property int $genre_id - Идентификатор жанра
 * @property int $age_limit_id - Идентификатор возрастного ограничения
 * @property int $level_id - Идентификатор уровня
 *
 * @property-read Filial $filial
 * @property-read Room $room
 * @property-read Type $type
 * @property-read Genre $genre
 * @property-read AgeLimit $age_limit
 * @property-read Level $level
 * @property-read QuestImage[] $images
 */
class Quest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover',
        'min_price',
        'late_price',
        'min_people',
        'max_people',
        'duration',
        'can_add_time',
        'is_active',
        'sequence_number',
        'weekdays',
        'weekend',
        'room_id',
        'type_id',
        'genre_id',
        'age_limit_id',
        'level_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'can_add_time' => 'boolean',
        'weekdays' => 'array',
        'weekend' => 'array',
    ];

    protected static function booted(): void
    {
        static::updated(function (Quest $quest) {
            if ($quest->isDirty('cover')) {
                Storage::delete('public/' . $quest->cover);
            }
        });

        static::deleted(function (Quest $quest) {
            Storage::delete('public/' . $quest->cover);
        });
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function filial(): HasOneThrough
    {
        return $this->hasOneThrough(
            Filial::class,
            Room::class,
            'id',
            'id',
            'room_id',
            'filial_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function age_limit(): BelongsTo
    {
        return $this->belongsTo(AgeLimit::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(QuestImage::class);
    }
}
