<?php

namespace App\Filament\Ujm\Resources\DokumenProdiResource\Pages;

use App\Filament\Ujm\Resources\DokumenProdiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDokumenProdi extends CreateRecord
{
  protected static string $resource = DokumenProdiResource::class;

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
