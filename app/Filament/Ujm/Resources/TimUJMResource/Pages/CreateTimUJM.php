<?php

namespace App\Filament\Ujm\Resources\TimUJMResource\Pages;

use App\Filament\Ujm\Resources\TimUJMResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTimUJM extends CreateRecord
{
  protected static string $resource = TimUJMResource::class;

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
