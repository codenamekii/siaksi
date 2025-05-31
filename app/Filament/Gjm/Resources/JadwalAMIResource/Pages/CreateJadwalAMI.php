<?php

namespace App\Filament\Gjm\Resources\JadwalAMIResource\Pages;

use App\Filament\Gjm\Resources\JadwalAMIResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJadwalAMI extends CreateRecord
{
  protected static string $resource = JadwalAMIResource::class;

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
