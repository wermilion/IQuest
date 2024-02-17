<?php

namespace App\Traits;

use App\Enums\TargetEnums;
use App\Models\Target;

trait BlockTrait
{
    private function getTargetId(TargetEnums $target): int
    {
        $target = Target::query()->firstWhere('title', $target->value);
        return $target->id;
    }
}
