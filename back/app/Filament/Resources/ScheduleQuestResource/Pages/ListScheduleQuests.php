<?php

namespace App\Filament\Resources\ScheduleQuestResource\Pages;

use App\Filament\Resources\ScheduleQuestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListScheduleQuests extends ListRecords
{
    protected static string $resource = ScheduleQuestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
