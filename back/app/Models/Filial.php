<?php

namespace App\Models;

use App\Traits\QuestRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filial extends Model
{
    use HasFactory, QuestRelationTrait;

    protected $fillable = [
        'address',
        'city_id',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    protected function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}
