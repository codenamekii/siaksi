<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Dokumen;
use App\Observers\DokumenObserver;
use App\Filament\Gjm\Widgets\JadwalAMICalendar;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register Observer
        Dokumen::observe(DokumenObserver::class);
        Livewire::component('filament.gjm.widgets.jadwal-ami-calendar', JadwalAMICalendar::class);
    }
}
