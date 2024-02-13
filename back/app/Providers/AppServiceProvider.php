<?php

namespace App\Providers;

use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup as FilamentNavigationGroup;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerNavigationGroups([
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::BOOKING->value),
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::SCHEDULE->value),
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::QUEST_COMPONENTS->value),
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::LOCATIONS->value),
            ]);
        });
    }
}
