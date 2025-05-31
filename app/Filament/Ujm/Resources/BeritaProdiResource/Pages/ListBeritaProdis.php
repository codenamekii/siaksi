<?php

namespace App\Filament\Ujm\Resources\BeritaProdiResource\Pages;

use App\Filament\Ujm\Resources\BeritaProdiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListBeritaProdis extends ListRecords
{
  protected static string $resource = BeritaProdiResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make()
        ->label('Buat Berita/Pengumuman'),
    ];
  }

  public function getTabs(): array
  {
    return [
      'all' => Tab::make('Semua'),
      'pengumuman' => Tab::make('Pengumuman')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('kategori', 'pengumuman'))
        ->badge(fn() => $this->getResource()::getEloquentQuery()->where('kategori', 'pengumuman')->count()),
      'berita' => Tab::make('Berita')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('kategori', 'berita'))
        ->badge(fn() => $this->getResource()::getEloquentQuery()->where('kategori', 'berita')->count()),
      'published' => Tab::make('Dipublikasikan')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('is_published', true)),
      'draft' => Tab::make('Draft')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('is_published', false)),
    ];
  }
}
