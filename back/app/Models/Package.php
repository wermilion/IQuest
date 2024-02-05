<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'min_price'
    ];

    public function holidays(): BelongsToMany
    {
        return $this->belongsToMany(Holiday::class, 'holiday_packages');
    }
}
