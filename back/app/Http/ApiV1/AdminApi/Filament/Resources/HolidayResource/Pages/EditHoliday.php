<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHoliday extends EditRecord
{
    protected static string $resource = HolidayResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getFormActions(): array
    {
        return [];
    }
}
