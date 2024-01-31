<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_slug',
        'desc',
        'cover',
        'min_price',
        'late_price',
        'min_people',
        'max_people',
        'duration',
        'add_time',
        'sequence_number',
        'room_id',
        'filial_id',
        'type_id',
        'genre_id',
        'age_limit_id',
        'level_id'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function filial(): BelongsTo
    {
        return $this->belongsTo(Filial::class);
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
}
