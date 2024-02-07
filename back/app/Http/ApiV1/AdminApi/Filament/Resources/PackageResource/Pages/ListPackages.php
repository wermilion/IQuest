<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\PackageResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\PackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPackages extends ListRecords
{
    protected static string $resource = PackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
