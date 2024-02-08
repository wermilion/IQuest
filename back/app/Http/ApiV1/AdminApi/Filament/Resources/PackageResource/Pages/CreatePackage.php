<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\PackageResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\PackageResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePackage extends CreateRecord
{
    protected static string $resource = PackageResource::class;
}
