<?php

namespace App\Filament\Gjm\Resources\BeritaResource\Pages;

use App\Filament\Gjm\Resources\BeritaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBerita extends CreateRecord
{
  protected static string $resource = BeritaResource::class;

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
