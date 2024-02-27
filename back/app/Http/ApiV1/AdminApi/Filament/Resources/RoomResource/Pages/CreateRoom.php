<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\RoomResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\RoomResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRoom extends CreateRecord
{
    protected static string $resource = RoomResource::class;

    protected ?string $heading = 'Создание комнаты';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
