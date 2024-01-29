<?php

namespace App\Models;

use App\Traits\QuestRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use HasFactory, SoftDeletes, QuestRelationTrait;

    protected $fillable = [
        'name',
    ];
}
