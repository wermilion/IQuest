<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoungeImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'lounge_id'
    ];

    public function lounge(): BelongsTo
    {
        return $this->belongsTo(Lounge::class);
    }
}
