<?php

namespace App\Filament\Ujm\Resources\TenagaKependidikanResource\Pages;

use App\Filament\Ujm\Resources\TenagaKependidikanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListTenagaKependidikans extends ListRecords
{
  protected static string $resource = TenagaKependidikanResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make()
        ->label('Tambah Tenaga Kependidikan'),
    ];
  }

  protected function getHeaderWidgets(): array
  {
    return [
      TenagaKependidikanResource\Widgets\TenagaKependidikanStats::class,
    ];
  }

  public function getTabs(): array
  {
    return [
      'all' => Tab::make('Semua'),
      'active' => Tab::make('Aktif')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('is_active', true))
        ->badge(fn() => $this->getResource()::getEloquentQuery()->where('is_active', true)->count()),
      'non_asn' => Tab::make('Non-ASN')
        ->modifyQueryUsing(fn(Builder $query) => $query->whereIn('status_kepegawaian', ['Tetap', 'Kontrak'])),
      'technical' => Tab::make('Teknis')
        ->modifyQueryUsing(fn(Builder $query) => $query->whereIn('jabatan', ['Laboran', 'Teknisi', 'Pranata Komputer'])),
    ];
  }
}
