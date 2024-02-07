<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLounge extends CreateRecord
{
    protected static string $resource = LoungeResource::class;
}
