<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleLounge extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time_from',
        'time_to',
        'lounge_id',
    ];
    
    public function lounge(): BelongsTo
    {
        return $this->belongsTo(Lounge::class);
    }
}
