<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\RoomResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\RoomResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRoom extends CreateRecord
{
    protected static string $resource = RoomResource::class;
}
