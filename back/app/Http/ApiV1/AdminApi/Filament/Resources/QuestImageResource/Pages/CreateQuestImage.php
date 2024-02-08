<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\QuestImageResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\QuestImageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateQuestImage extends CreateRecord
{
    protected static string $resource = QuestImageResource::class;
}
