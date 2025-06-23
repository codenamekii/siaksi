<?php

namespace App\Providers\Filament;

use App\Filament\Gjm\Pages\Dashboard;
use App\Filament\Gjm\Resources;
use App\Filament\Gjm\Widgets;
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
use Illuminate\Support\Facades\Auth;

class GjmPanelProvider extends PanelProvider
{
  public function panel(Panel $panel): Panel
  {
    return $panel
      ->id('gjm')
      ->path('gjm')
      ->login()
      ->profile()
      ->colors([
        'primary' => Color::Blue,
        'danger' => Color::Red,
        'gray' => Color::Gray,
        'info' => Color::Sky,
        'success' => Color::Green,
        'warning' => Color::Amber,
      ])
      ->sidebarCollapsibleOnDesktop()
      ->discoverResources(in: app_path('Filament/Gjm/Resources'), for: 'App\\Filament\\Gjm\\Resources')
      ->discoverPages(in: app_path('Filament/Gjm/Pages'), for: 'App\\Filament\\Gjm\\Pages')
      ->pages([
        Dashboard::class,
      ])
      ->discoverWidgets(in: app_path('Filament/Gjm/Widgets'), for: 'App\\Filament\\Gjm\\Widgets')
      ->widgets([
        \App\Filament\Gjm\Widgets\InfoCenterWidget::class,
        \App\Filament\Gjm\Widgets\QuickAccessWidget::class,
        \App\Filament\Gjm\Widgets\FakultasSummaryWidget::class,
        \App\Filament\Gjm\Widgets\ProgramStudiStatsWidget::class,
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
        SetTheme::class, // Add theme middleware
      ])
      ->authMiddleware([
        Authenticate::class,
      ])
      ->navigationGroups([
        NavigationGroup::make()
          ->label('Beranda'),
        NavigationGroup::make()
          ->label('Profil'),
        NavigationGroup::make()
          ->label('Manajemen Dokumen'),
        NavigationGroup::make()
          ->label('Audit Mutu Internal'),
        NavigationGroup::make()
          ->label('Akreditasi'),
        NavigationGroup::make()
          ->label('Pengaturan'),
        NavigationGroup::make()
          ->label('Laporan'),
      ])
      ->brandName('Gugus Jaminan Mutu')
      ->favicon(asset('images/favicon.ico'))
      ->plugins([
        ThemesPlugin::make()
          ->canViewThemesPage(fn() => \Illuminate\Support\Facades\Auth::user()?->role === 'gjm') // Only GJM can change themes
      ]);
  }
}
