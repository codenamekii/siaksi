<?php

namespace App\Filament\Ujm\Resources\DokumenProdiResource\Pages;

use App\Filament\Ujm\Resources\DokumenProdiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListDokumenProdis extends ListRecords
{
  protected static string $resource = DokumenProdiResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make()
        ->label('Upload Dokumen Baru'),
    ];
  }

  public function getTabs(): array
  {
    return [
      'all' => Tab::make('Semua'),
      'akreditasi' => Tab::make('Dokumen Akreditasi')
        ->modifyQueryUsing(fn(Builder $query) => $query->whereIn('kategori', ['lkps', 'evaluasi_diri', 'sertifikat_akreditasi'])),
      'laporan' => Tab::make('Laporan')
        ->modifyQueryUsing(fn(Builder $query) => $query->whereIn('kategori', ['laporan_ami', 'laporan_survei'])),
      'visible_asesor' => Tab::make('Terlihat Asesor')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('is_visible_to_asesor', true))
        ->badge(fn() => $this->getResource()::getEloquentQuery()->where('is_visible_to_asesor', true)->count()),
    ];
  }
}
