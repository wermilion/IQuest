<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\PackageResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\PackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPackage extends EditRecord
{
    protected static string $resource = PackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
