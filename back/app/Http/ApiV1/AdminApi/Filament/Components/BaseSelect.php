<?php

namespace App\Http\ApiV1\AdminApi\Filament\Components;

use Filament\Forms\Components\Select;

class BaseSelect extends Select
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (BaseSelect $component) {
            if (empty($component->getOptions())) {
                $this->options([
                    '' => 'Нет подходящих вариантов',
                ]);
            }
        });
    }
}
