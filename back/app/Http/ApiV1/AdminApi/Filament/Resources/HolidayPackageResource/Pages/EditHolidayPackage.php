<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\HolidayPackageResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHolidayPackage extends EditRecord
{
    protected static string $resource = HolidayPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
