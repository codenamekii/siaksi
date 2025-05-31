<?php

// 1. app/Filament/Ujm/Resources/TenagaKependidikanResource/Pages/CreateTenagaKependidikan.php
namespace App\Filament\Ujm\Resources\TenagaKependidikanResource\Pages;

use App\Filament\Ujm\Resources\TenagaKependidikanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTenagaKependidikan extends CreateRecord
{
  protected static string $resource = TenagaKependidikanResource::class;

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}