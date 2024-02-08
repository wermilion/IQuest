<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\HolidayPackageResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHolidayPackages extends ListRecords
{
    protected static string $resource = HolidayPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
