<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lounge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cover',
        'max_people',
        'min_price',
        'is_active',
        'filial_id',
    ];

    public function filial(): BelongsTo
    {
        return $this->belongsTo(Filial::class);
    }
}
