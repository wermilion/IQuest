<?php

namespace App\Models;

use App\Domain\Locations\Models\Filial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
