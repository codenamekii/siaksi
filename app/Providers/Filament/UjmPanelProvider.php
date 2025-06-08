<?php
// Lokasi file: app/Providers/Filament/UjmPanelProvider.php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
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
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RedirectIfNotUJMOrAuthorized;
use App\Http\Middleware\RedirectIfNotUJMOrGJM;


class UjmPanelProvider extends PanelProvider
{
  public function panel(Panel $panel): Panel
  {
    return $panel
      ->id('ujm')
      ->path('ujm')
      ->login()
      ->authGuard('web')
      ->colors([
        'primary' => Color::Blue,
      ])
      ->brandName('Unit Jaminan Mutu')
      ->brandLogo('')
      ->brandLogoHeight('3rem')
      ->favicon(asset('images/favicon.ico'))
      ->discoverResources(in: app_path('Filament/Ujm/Resources'), for: 'App\\Filament\\Ujm\\Resources')
      ->discoverPages(in: app_path('Filament/Ujm/Pages'), for: 'App\\Filament\\Ujm\\Pages')
      ->pages([
        \App\Filament\Ujm\Pages\Dashboard::class,
      ])
      ->discoverWidgets(in: app_path('Filament/Ujm/Widgets'), for: 'App\\Filament\\Ujm\\Widgets')
      ->widgets([
        \App\Filament\Ujm\Widgets\StatsOverview::class,
        \App\Filament\Ujm\Widgets\RecentActivities::class,
        \App\Filament\Ujm\Widgets\DocumentStatus::class,
      ])
      ->plugin(
        \Hasnayeen\Themes\ThemesPlugin::make()
          ->canViewThemesPage(fn() => Auth::user()?->is_ujm_admin === true)
      )
      ->navigationGroups([
        NavigationGroup::make()
          ->label('Profil')
          ->icon('heroicon-o-building-office-2')
          ->collapsed(false), // Default expanded
        NavigationGroup::make()
          ->label('Konten')
          ->icon('heroicon-o-newspaper')
          ->collapsed(),
        NavigationGroup::make()
          ->label('Dokumen')
          ->icon('heroicon-o-folder')
          ->collapsed(),
        NavigationGroup::make()
          ->label('Evaluasi & Peningkatan')
          ->icon('heroicon-o-chart-bar')
          ->collapsed(),
        NavigationGroup::make()
          ->label('Akreditasi')
          ->icon('heroicon-o-academic-cap')
          ->collapsed(),
        NavigationGroup::make()
          ->label('Organisasi')
          ->icon('heroicon-o-user-group')
          ->collapsed(),
        NavigationGroup::make()
          ->label('Data Pendukung')
          ->icon('heroicon-o-circle-stack')
          ->collapsed(),
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
      ])
      ->authMiddleware([
        Authenticate::class,
        RedirectIfNotUJMOrGJM::class, // Tambahkan middleware fleksibel
      ])
      ->authGuard('web')
      ->tenant(null)
      ->sidebarCollapsibleOnDesktop()
      ->breadcrumbs(true)
      ->spa();
  }
}