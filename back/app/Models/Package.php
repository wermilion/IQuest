<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'min_people',
        'max_people',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function holidays(): BelongsToMany
    {
        return $this->belongsToMany(Holiday::class, 'holiday_packages');
    }

    public function holidayPackages(): HasMany
    {
        return $this->hasMany(HolidayPackage::class);
    }
}
