<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
    ];

    public function holidayPackages(): HasMany
    {
        return $this->hasMany(HolidayPackage::class);
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'holiday_packages');
    }
}
