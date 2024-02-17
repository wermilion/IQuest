<?php

namespace App\Filament\Resources\MainBlockResource\Pages;

use App\Filament\Resources\MainBlockResource;
use App\Models\Block;
use App\Models\Target;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ListMainBlocks extends ListRecords
{
    protected static string $resource = MainBlockResource::class;

    protected function getActions(): array
    {
        return [
            //
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

    protected function getTableQuery(): Builder
    {
        $target = Target::query()->firstWhere(['title' => 'главный']);
        return Block::query()->where('target_id', $target->id);
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
