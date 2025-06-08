<?php

namespace App\Filament\Gjm\Resources\StrukturOrganisasiFakultasResource\Pages;

use App\Filament\Gjm\Resources\StrukturOrganisasiFakultasResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateStrukturOrganisasiFakultas extends CreateRecord
{
  protected static string $resource = StrukturOrganisasiFakultasResource::class;

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }

  protected function getCreatedNotification(): ?Notification
  {
    return Notification::make()
      ->success()
      ->title('Struktur organisasi berhasil diupload')
      ->body('Struktur organisasi fakultas telah berhasil disimpan.');
  }
}
