<?php

namespace App\Filament\Ujm\Resources\BeritaProdiResource\Pages;

use App\Filament\Ujm\Resources\BeritaProdiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBeritaProdi extends CreateRecord
{
  protected static string $resource = BeritaProdiResource::class;

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
