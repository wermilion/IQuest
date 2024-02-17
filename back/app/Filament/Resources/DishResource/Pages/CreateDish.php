<?php

namespace App\Filament\Resources\DishResource\Pages;

use App\Filament\Resources\DishResource;
use App\Models\Category;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDish extends CreateRecord
{
    protected static string $resource = DishResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['metric_value']) && empty($data['metric_id'])) {
            Notification::make()
                ->danger()
                ->title('Ошибка')
                ->body("Поле 'Ед. измерения' обязательно, если в поле 'Вес/объём' указано какое-либо значение ")
                ->seconds(5)
                ->send();
            $this->halt();
        }
        return $data;
    }
}
