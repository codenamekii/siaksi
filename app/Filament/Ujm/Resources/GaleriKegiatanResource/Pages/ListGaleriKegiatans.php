<?php

namespace App\Filament\Ujm\Resources\GaleriKegiatanResource\Pages;

use App\Filament\Ujm\Resources\GaleriKegiatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGaleriKegiatans extends ListRecords
{
  protected static string $resource = GaleriKegiatanResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make()
        ->label('Upload Dokumentasi Baru'),
    ];
  }
}
