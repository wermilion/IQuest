<?php

namespace App\Filament\Resources\SubcategoryResource\Pages;

use App\Filament\Resources\SubcategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubcategories extends ListRecords
{
    protected static string $resource = SubcategoryResource::class;

    protected function getActions(): array
    {
        return [
            //
        ];
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'id';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'asc';
    }
}
