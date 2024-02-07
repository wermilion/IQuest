<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\RoomResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\RoomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRooms extends ListRecords
{
    protected static string $resource = RoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
