<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'is_cover',
        'quest_id'
    ];

    protected $casts = [
        'is_cover' => 'boolean'
    ];

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }
}
