<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function filials(): HasMany
    {
        return $this->hasMany(Filial::class);
    }
}
