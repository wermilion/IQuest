<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\TimeslotResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\TimeslotResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimeslots extends ListRecords
{
    protected static string $resource = TimeslotResource::class;

    protected ?string $heading = 'Расписание квестов';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
