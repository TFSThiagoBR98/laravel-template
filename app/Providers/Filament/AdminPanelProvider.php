<?php

namespace App\Providers\Filament;

use Awcodes\FilamentQuickCreate\QuickCreatePlugin;
use Awcodes\FilamentVersions\VersionsPlugin;
use Awcodes\FilamentVersions\VersionsWidget;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Croustibat\FilamentJobsMonitor\FilamentJobsMonitorPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Marjose123\FilamentWebhookServer\WebhookPlugin;
use Hasnayeen\Themes\ThemesPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;
use Tapp\FilamentAuthenticationLog\FilamentAuthenticationLogPlugin;
use TFSThiagoBR98\FilamentTwoFactor\FilamentTwoFactorPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->maxContentWidth('full')
            // ->brandLogo(asset('assets/images/logo_opcaoativa.svg'))
            // ->darkModeBrandLogo(asset('assets/images/logo_opcaoativa_dark.svg'))
            // ->favicon(asset('favicon-32x32.png'))
            // ->brandLogoHeight('3rem')
            ->sidebarFullyCollapsibleOnDesktop()
            ->login(action: \TFSThiagoBR98\FilamentTwoFactor\Http\Livewire\Auth\Login::class)
            ->colors([
                'primary' => [
                    '50' => '#f2f9f9',
                    '100' => '#ddeff0',
                    '200' => '#bfe0e2',
                    '300' => '#92cace',
                    '400' => '#5faab1',
                    '500' => '#438e96',
                    '600' => '#3b757f',
                    '700' => '#356169',
                    '800' => '#325158',
                    '900' => '#2d464c',
                    '950' => '#1a2c32',
                ],
                'wedgewood' => [
                    '50' => '#f2f9f9',
                    '100' => '#ddeff0',
                    '200' => '#bfe0e2',
                    '300' => '#92cace',
                    '400' => '#5faab1',
                    '500' => '#438e96',
                    '600' => '#3b757f',
                    '700' => '#356169',
                    '800' => '#325158',
                    '900' => '#2d464c',
                    '950' => '#1a2c32',
                ]
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                VersionsWidget::class,
            ])
            ->plugins([
                WebhookPlugin::make(),
                FilamentTwoFactorPlugin::make(),
                FilamentAuthenticationLogPlugin::make(),
                EnvironmentIndicatorPlugin::make()
                    ->visible(true),
                ThemesPlugin::make(),
                VersionsPlugin::make(),
                QuickCreatePlugin::make(),
                FilamentShieldPlugin::make(),
                FilamentJobsMonitorPlugin::make()
                    ->label('Tarefa')
                    ->pluralLabel('Tarefas')
                    ->enableNavigation(true)
                    ->navigationIcon('heroicon-o-cpu-chip')
                    ->navigationGroup('Sistema')
                    ->navigationSort(5)
                    ->navigationCountBadge(true)
                    ->enablePruning(true)
                    ->pruningRetention(7),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
