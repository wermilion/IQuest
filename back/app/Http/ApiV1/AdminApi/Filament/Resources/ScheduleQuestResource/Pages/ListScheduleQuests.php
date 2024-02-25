<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleQuestResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleQuestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListScheduleQuests extends ListRecords
{
    protected static string $resource = ScheduleQuestResource::class;

    protected ?string $heading = 'Расписание квестов';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
