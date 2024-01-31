<?php

namespace App\Filament\Resources\LoungeResource\Pages;

use App\Filament\Resources\LoungeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLounges extends ListRecords
{
    protected static string $resource = LoungeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
