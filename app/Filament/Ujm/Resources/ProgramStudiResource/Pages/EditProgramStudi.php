<?php

namespace App\Filament\Ujm\Resources\ProgramStudiResource\Pages;

use App\Filament\Ujm\Resources\ProgramStudiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditProgramStudi extends EditRecord
{
  protected static string $resource = ProgramStudiResource::class;

  protected function getHeaderActions(): array
  {
    return [
      //
    ];
  }

  protected function getSavedNotification(): ?Notification
  {
    return Notification::make()
      ->success()
      ->title('Profil Program Studi berhasil diperbarui')
      ->body('Visi, Misi, Tujuan dan informasi pimpinan telah disimpan.');
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
