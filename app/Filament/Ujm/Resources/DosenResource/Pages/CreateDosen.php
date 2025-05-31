<?php

namespace App\Filament\Ujm\Resources\DosenResource\Pages;

use App\Filament\Ujm\Resources\DosenResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDosen extends CreateRecord
{
  protected static string $resource = DosenResource::class;

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
