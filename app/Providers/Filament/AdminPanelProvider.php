<?php

namespace App\Providers\Filament;

use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource;
use Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource;
use App\Filament\Auth\Login;
use App\Filament\Resources\UserResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;
use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->spa(true)
            ->id('admin')
            ->path('admin')
            ->darkMode(false)
            ->login(Login::class)
            ->topNavigation(true)
            ->colors(
                [
                    'primary' => Color::Blue,
                ],
            )
            ->globalSearch(false)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages(
                [],
            )
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets(
                [],
            )
            ->viteTheme('resources/css/filament/admin/theme.scss')
            ->middleware(
                [
                    EncryptCookies::class,
                    AddQueuedCookiesToResponse::class,
                    StartSession::class,
                    AuthenticateSession::class,
                    ShareErrorsFromSession::class,
                    VerifyCsrfToken::class,
                    SubstituteBindings::class,
                    DisableBladeIconComponents::class,
                    DispatchServingFilamentEvent::class,
                ],
            )
            ->authMiddleware(
                [
                    Authenticate::class,
                ],
            )
            ->plugins(
                [
                    FilamentSpatieRolesPermissionsPlugin::make(),
                    BreezyCore::make()->myProfile(
                        shouldRegisterUserMenu: true,
                        shouldRegisterNavigation: false,
                        hasAvatars: true,
                        slug: 'my-profile',
                    ),
                    FilamentApexChartsPlugin::make(),
                    FilamentSpatieLaravelBackupPlugin::make(),
                ],
            )
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->items([])->groups([
                    NavigationGroup::make('Master Data')
                        ->items([
                            ...UserResource::getNavigationItems(),
                        ]),
                    NavigationGroup::make('Pengaturan')
                        ->items([
                            ...RoleResource::getNavigationItems(),
                            ...PermissionResource::getNavigationItems(),
                            ...Backups::getNavigationItems(),
                        ]),
                ]);
            });
    }
}
