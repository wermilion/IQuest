<?php

namespace App\Domain\Services\Models;

use App\Domain\Locations\Models\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'unit',
        'city_id',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
