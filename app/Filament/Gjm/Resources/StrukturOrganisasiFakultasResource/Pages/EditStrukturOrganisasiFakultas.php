<?php

namespace App\Filament\Gjm\Resources\StrukturOrganisasiFakultasResource\Pages;

use App\Filament\Gjm\Resources\StrukturOrganisasiFakultasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditStrukturOrganisasiFakultas extends EditRecord
{
  protected static string $resource = StrukturOrganisasiFakultasResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }

  protected function getSavedNotification(): ?Notification
  {
    return Notification::make()
      ->success()
      ->title('Struktur organisasi berhasil diperbarui')
      ->body('Perubahan struktur organisasi telah disimpan.');
  }
}