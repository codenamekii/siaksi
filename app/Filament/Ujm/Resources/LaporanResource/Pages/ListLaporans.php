<?php

namespace App\Filament\Ujm\Resources\LaporanResource\Pages;

use App\Filament\Ujm\Resources\LaporanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListLaporans extends ListRecords
{
  protected static string $resource = LaporanResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make()
        ->label('Upload Laporan Baru'),
    ];
  }

  public function getTabs(): array
  {
    return [
      'all' => Tab::make('Semua Laporan'),
      'ami' => Tab::make('Laporan AMI')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('kategori', 'laporan_ami'))
        ->badge(fn() => $this->getResource()::getEloquentQuery()->where('kategori', 'laporan_ami')->count()),
      'survei' => Tab::make('Survei Kepuasan')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('kategori', 'laporan_survei'))
        ->badge(fn() => $this->getResource()::getEloquentQuery()->where('kategori', 'laporan_survei')->count()),
      'capaian' => Tab::make('Analisis Capaian')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('kategori', 'analisis_capaian')),
      'rtl' => Tab::make('RTL')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('kategori', 'rencana_tindak_lanjut')),
      'current_year' => Tab::make('Tahun ' . date('Y'))
        ->modifyQueryUsing(fn(Builder $query) => $query->where('tahun', date('Y'))),
    ];
  }
}
