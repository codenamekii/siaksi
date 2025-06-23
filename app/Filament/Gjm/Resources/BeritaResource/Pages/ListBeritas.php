<?php

namespace App\Filament\Gjm\Resources\BeritaResource\Pages;

use App\Filament\Gjm\Resources\BeritaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListBeritas extends ListRecords
{
  protected static string $resource = BeritaResource::class;

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
      'published' => Tab::make('Dipublikasikan')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('is_published', true)),
      'draft' => Tab::make('Draft')
        ->modifyQueryUsing(fn(Builder $query) => $query->where('is_published', false)),
    ];
  }
}
