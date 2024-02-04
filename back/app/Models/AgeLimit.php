<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgeLimit extends Model
{
    use HasFactory;

    protected $fillable = [
        'limit'
    ];
}
