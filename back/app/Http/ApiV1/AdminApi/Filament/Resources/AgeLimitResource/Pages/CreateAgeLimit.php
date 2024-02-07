<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAgeLimit extends CreateRecord
{
    protected static string $resource = AgeLimitResource::class;
}
