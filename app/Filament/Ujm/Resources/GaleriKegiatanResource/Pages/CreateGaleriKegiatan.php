<?php

namespace App\Filament\Ujm\Resources\GaleriKegiatanResource\Pages;

use App\Filament\Ujm\Resources\GaleriKegiatanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGaleriKegiatan extends CreateRecord
{
  protected static string $resource = GaleriKegiatanResource::class;

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    // Jika multiple files, ambil file pertama untuk preview
    if (isset($data['file_path']) && is_array($data['file_path'])) {
      $data['file_path'] = $data['file_path'][0] ?? null;
    }

    return $data;
  }
}
