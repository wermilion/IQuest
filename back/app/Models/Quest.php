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
        'room_id',
        'type_id',
        'genre_id',
        'age_limit_id',
        'level_id'
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
