<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\HolidayPackageResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayPackageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHolidayPackage extends CreateRecord
{
    protected static string $resource = HolidayPackageResource::class;
}
