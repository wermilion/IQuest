<?php

namespace App\Filament\Resources\QuestResource\Pages;

use App\Filament\Resources\QuestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateQuest extends CreateRecord
{
    protected static string $resource = QuestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['weekdays'] = explode("\n", $data['weekdays']);
        $data['weekend'] = explode("\n", $data['weekend']);

        return $data;
    }
}
