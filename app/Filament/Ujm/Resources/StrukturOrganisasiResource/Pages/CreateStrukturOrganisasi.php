<?php

// Lokasi file: app/Filament/Ujm/Resources/StrukturOrganisasiResource/Pages/CreateStrukturOrganisasi.php

namespace App\Filament\Ujm\Resources\StrukturOrganisasiResource\Pages;

use App\Filament\Ujm\Resources\StrukturOrganisasiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class CreateStrukturOrganisasi extends CreateRecord
{
  protected static string $resource = StrukturOrganisasiResource::class;

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }

  protected function getCreatedNotificationTitle(): ?string
  {
    return 'Struktur organisasi berhasil diupload';
  }

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    // Ensure proper data structure
    $data['level'] = 'prodi';
    $data['program_studi_id'] = Auth::user()->program_studi_id;

    return $data;
  }

  protected function afterCreate(): void
  {
    // Additional notification if this is set as active
    if ($this->record->is_active) {
      Notification::make()
        ->title('Struktur organisasi aktif')
        ->body('Struktur organisasi ini telah diset sebagai struktur aktif. Struktur sebelumnya telah dinonaktifkan.')
        ->success()
        ->send();
    }
  }
}