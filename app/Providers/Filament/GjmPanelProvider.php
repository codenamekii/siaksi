<?php

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

class GjmPanelProvider extends PanelProvider
{
  public function panel(Panel $panel): Panel
  {
    return $panel
      ->id('gjm')
      ->path('gjm')
      ->login()
      ->authGuard('web')
      ->colors([
        'primary' => Color::Amber,
      ])
      ->brandName('Gugus Jaminan Mutu')
      ->brandLogo('')
      ->brandLogoHeight('3rem')
      ->favicon(asset('images/favicon.ico'))
      ->discoverResources(in: app_path('Filament/Gjm/Resources'), for: 'App\\Filament\\Gjm\\Resources')
      ->discoverPages(in: app_path('Filament/Gjm/Pages'), for: 'App\\Filament\\Gjm\\Pages')
      ->pages([
        \App\Filament\Gjm\Pages\Dashboard::class,
      ])
      ->discoverWidgets(in: app_path('Filament/Gjm/Widgets'), for: 'App\\Filament\\Gjm\\Widgets')
      ->widgets([
        // Default widgets
      ])
      ->navigationGroups([
        NavigationGroup::make()
          ->label('User Management')
          ->icon('heroicon-o-users')
          ->collapsed(),
        NavigationGroup::make()
          ->label('Konten')
          ->icon('heroicon-o-document-text')
          ->collapsed(),
        NavigationGroup::make()
          ->label('Dokumen')
          ->icon('heroicon-o-folder')
          ->collapsed(),
        NavigationGroup::make()
          ->label('Audit Mutu Internal')
          ->icon('heroicon-o-clipboard-document-check')
          ->collapsed(),
        NavigationGroup::make()
          ->label('Organisasi')
          ->icon('heroicon-o-building-office')
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
      ])
      ->authGuard('web')
      ->tenant(null)
      ->sidebarCollapsibleOnDesktop()
      ->breadcrumbs(true)
      ->spa();
  }
}