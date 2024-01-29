<?php

namespace App\Traits;

use App\Models\Quest;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait QuestRelationTrait
{
    public function quests(): HasMany
    {
        return $this->hasMany(Quest::class);
    }
}
