<?php

namespace App\Filament\Ujm\Resources\AkreditasiResource\Pages;

use App\Filament\Ujm\Resources\AkreditasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\AkreditasiProdi;
use Illuminate\Support\Facades\Auth;

class EditAkreditasi extends EditRecord
{
  protected static string $resource = AkreditasiResource::class;

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

  protected function mutateFormDataBeforeSave(array $data): array
  {
    // Ensure program_studi_id is always set
    $data['program_studi_id'] = Auth::user()->program_studi_id;

    // Set tahun_akreditasi if tanggal_akreditasi is set
    if (isset($data['tanggal_akreditasi'])) {
      $data['tahun_akreditasi'] = \Carbon\Carbon::parse($data['tanggal_akreditasi'])->year;
    }

    return $data;
  }

  protected function beforeSave(): void
  {
    // If this akreditasi is set as active, deactivate others
    if ($this->data['is_active'] ?? false) {
      AkreditasiProdi::where('program_studi_id', Auth::user()->program_studi_id)
        ->where('id', '!=', $this->record->id)
        ->update(['is_active' => false]);
    }
  }

  protected function getSavedNotificationTitle(): ?string
  {
    return 'Akreditasi berhasil diperbarui';
  }
}