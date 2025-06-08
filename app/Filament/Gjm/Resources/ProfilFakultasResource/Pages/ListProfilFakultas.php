<?php
// Lokasi file: app/Filament/Gjm/Resources/ProfilFakultasResource/Pages/ListProfilFakultas.php

namespace App\Filament\Gjm\Resources\ProfilFakultasResource\Pages;

use App\Filament\Gjm\Resources\ProfilFakultasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfilFakultas extends ListRecords
{
  protected static string $resource = ProfilFakultasResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
