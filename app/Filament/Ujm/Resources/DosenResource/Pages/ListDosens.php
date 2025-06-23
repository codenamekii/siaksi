<?php

namespace App\Filament\Ujm\Resources\DosenResource\Pages;

use App\Filament\Ujm\Resources\DosenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListDosens extends ListRecords
{
  protected static string $resource = DosenResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make()
        ->label('Tambah Dosen'),
    ];
  }

  protected function getHeaderWidgets(): array
  {
    return [
      // DosenResource\Widgets\DosenStats::class,
    ];
  }

  public function getTabs(): array
  {
    return [
      'all' => Tab::make('Semua'),
      'active' => Tab::make('Aktif')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('is_active', true))
        ->badge(fn() => $this->getResource()::getEloquentQuery()->where('is_active', true)->count()),
      'professor' => Tab::make('Profesor')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('jabatan_akademik', 'Profesor')),
      's3' => Tab::make('Doktor (S3)')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('pendidikan_terakhir', 'S3')),
      'inactive' => Tab::make('Non-Aktif')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('is_active', false)),
    ];
  }
}
