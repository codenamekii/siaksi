<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
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
use Hasnayeen\Themes\ThemesPlugin;
use Hasnayeen\Themes\Http\Middleware\SetTheme;

class UjmPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('ujm')
            ->path('ujm')
            ->login()
            ->profile()
            ->colors([
                'primary' => Color::Emerald,
                'danger' => Color::Red,
                'gray' => Color::Gray,
                'info' => Color::Sky,
                'success' => Color::Green,
                'warning' => Color::Amber,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->discoverResources(in: app_path('Filament/Ujm/Resources'), for: 'App\\Filament\\Ujm\\Resources')
            ->discoverPages(in: app_path('Filament/Ujm/Pages'), for: 'App\\Filament\\Ujm\\Pages')
            ->discoverWidgets(in: app_path('Filament/Ujm/Widgets'), for: 'App\\Filament\\Ujm\\Widgets')
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
                SetTheme::class, // Add theme middleware
            ])
            ->authMiddleware([Authenticate::class])
            ->navigationGroups([NavigationGroup::make()->label('Beranda'), NavigationGroup::make()->label('Profil UJM'), NavigationGroup::make()->label('Dokumen Mutu'), NavigationGroup::make()->label('Evaluasi & Peningkatan'), NavigationGroup::make()->label('Akreditasi'), NavigationGroup::make()->label('Dokumentasi')])
            ->brandName('Unit Jaminan Mutu')
            ->favicon(asset('images/favicon.ico'))
            ->plugins([
                ThemesPlugin::make()->canViewThemesPage(fn() => \Illuminate\Support\Facades\Auth::user()?->role === 'ujm'), // Only UJM can change themes for their panel
            ]);
    }
}
