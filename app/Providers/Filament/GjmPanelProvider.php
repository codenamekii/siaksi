<?php
// Lokasi file: app/Providers/Filament/GjmPanelProvider.php

namespace App\Providers\Filament;

use App\Http\Middleware\FilamentAuthenticate as Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\RedirectIfNotGJM;

class GjmPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('gjm')
            ->path('gjm')
            ->login()
            ->colors([
                'primary' => Color::Amber,
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Gjm/Resources'), for: 'App\\Filament\\Gjm\\Resources')
            ->discoverPages(in: app_path('Filament/Gjm/Pages'), for: 'App\\Filament\\Gjm\\Pages')
            ->pages([Pages\Dashboard::class])
            ->discoverWidgets(in: app_path('Filament/Gjm/Widgets'), for: 'App\\Filament\\Gjm\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([EncryptCookies::class, AddQueuedCookiesToResponse::class, StartSession::class, AuthenticateSession::class, ShareErrorsFromSession::class, VerifyCsrfToken::class, SubstituteBindings::class, DisableBladeIconComponents::class, DispatchServingFilamentEvent::class])
            ->authMiddleware([Authenticate::class, RedirectIfNotGJM::class])
            ->navigationGroups(['Dashboard', 'Manajemen Mutu', 'Informasi', 'Dokumentasi', 'Pengaturan'])
            ->sidebarCollapsibleOnDesktop()
            ->brandName('SIAKSI - GJM Panel')
            ->favicon(asset('images/logo.png'))
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->authGuard('web')
            ->tenant(null)
            ->sidebarCollapsibleOnDesktop()
            ->breadcrumbs(true)
            ->spa();
    }
}
