<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
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

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
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
