<?php

namespace App\Models;

use App\Domain\Quests\Models\Quest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleQuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'activity_status',
        'quest_id'
    ];

    protected $casts = [
        'activity_status' => 'boolean'
    ];

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }
}
