<?php

namespace App\Filament\Resources\LoungeImageResource\Pages;

use App\Filament\Resources\LoungeImageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLoungeImages extends ListRecords
{
    protected static string $resource = LoungeImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
