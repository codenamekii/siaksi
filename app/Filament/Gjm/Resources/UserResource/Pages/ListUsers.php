<?php

namespace App\Filament\Gjm\Resources\UserResource\Pages;

use App\Filament\Gjm\Resources\UserResource;
use App\Filament\Gjm\Resources\JadwalAMIResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
  protected static string $resource = UserResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make()
        ->label('Buat Jadwal AMI'),
    ];
  }

  public function getTabs(): array
  {
    return [
      'all' => Tab::make('Semua'),
      'upcoming' => Tab::make('Akan Datang')
        ->modifyQueryUsing(fn(Builder $query) => $query
          ->where('status', 'scheduled')
          ->where('tanggal_mulai', '>=', now())),
      'ongoing' => Tab::make('Berlangsung')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'ongoing')),
      'completed' => Tab::make('Selesai')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'completed')),
    ];
  }

  protected function getHeaderWidgets(): array
  {
    return [
      JadwalAMIResource\Widgets\JadwalAMICalendar::class,
    ];
  }
}
