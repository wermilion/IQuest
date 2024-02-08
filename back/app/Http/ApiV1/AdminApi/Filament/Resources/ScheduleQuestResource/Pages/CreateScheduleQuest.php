<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleQuestResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleQuestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateScheduleQuest extends CreateRecord
{
    protected static string $resource = ScheduleQuestResource::class;
}
