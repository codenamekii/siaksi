<?php
// Lokasi file: app/Filament/Gjm/Resources/StrukturOrganisasiFakultasResource/Pages/ListStrukturOrganisasiFakultas.php

namespace App\Filament\Gjm\Resources\StrukturOrganisasiFakultasResource\Pages;

use App\Filament\Gjm\Resources\StrukturOrganisasiFakultasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;


class ListStrukturOrganisasiFakultas extends ListRecords
{
  protected static string $resource = StrukturOrganisasiFakultasResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make()
        ->label('Upload Struktur Baru'),
    ];
  }

  public function getHeading(): string|\Illuminate\Contracts\Support\Htmlable
  {
    return 'Struktur Organisasi Fakultas';
  }

  public function getSubheading(): string|Htmlable|null
  {
    return 'Kelola gambar struktur organisasi fakultas';
  }
}
