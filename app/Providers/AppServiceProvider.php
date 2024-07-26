<?php

namespace App\Providers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (config('app.force_https')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(UrlGenerator $url): void
    {
        Schema::defaultStringLength(191);

        // DateTimePicker::$defaultDateTimeDisplayFormat = '';

        if (config('app.force_https')) {
            $url->forceScheme('https');
        }
        Select::configureUsing(
            fn ($component) => $component
                ->native(false)
                ->searchable(true),
        );

        SelectFilter::configureUsing(
            fn ($component) => $component
                ->native(false)
                ->searchable(true),
        );

        DatePicker::configureUsing(
            fn ($component) => $component
                ->displayFormat('l, d M. Y')
                ->native(false),
        );

        $this->autoTranslateLabels();

        TextInput::macro(
            'currencyMask',
            function ($thousandSeparator = '.', $decimalSeparator = ',', $precision = 0) {
                $this->view = 'filament-currency::currency-mask';
                $this->viewData(compact('thousandSeparator', 'decimalSeparator', 'precision'));

                return $this;
            },
        );
    }

    private function autoTranslateLabels(): void
    {
        // TODO: masukan komponent filament yang di ingingkan
        $this->translateLabels(
            [
                Field::class,
                BaseFilter::class,
                Placeholder::class,
                TextInput::class,
                Section::class,
                TextColumn::class,
                // or even `BaseAction::class`,
            ],
        );
    }

    private function translateLabels(array $components = []): void
    {
        foreach ($components as $component) {
            $component::configureUsing(
                function ($c): void {
                    $c->translateLabel();
                },
            );
        }
    }
}
