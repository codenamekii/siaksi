<?php

namespace App\Filament\Ujm\Resources\AkreditasiResource\Pages;

use App\Filament\Ujm\Resources\AkreditasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\AkreditasiProdi;

class EditAkreditasi extends EditRecord
{
  protected static string $resource = AkreditasiResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('setActive')
        ->label('Set Sebagai Aktif')
        ->icon('heroicon-o-check-circle')
        ->color('success')
        ->visible(fn() => !$this->record->is_active)
        ->requiresConfirmation()
        ->action(function () {
          // Nonaktifkan semua akreditasi lain
          AkreditasiProdi::where('program_studi_id', $this->record->program_studi_id)
            ->update(['is_active' => false]);

          // Aktifkan akreditasi ini
          $this->record->update(['is_active' => true]);
        }),
      Actions\DeleteAction::make(),
    ];
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }

  protected function beforeSave(): void
  {
    // Jika akreditasi ini diset aktif, nonaktifkan yang lain
    if ($this->data['is_active'] && !$this->record->is_active) {
      AkreditasiProdi::where('program_studi_id', $this->record->program_studi_id)
        ->where('id', '!=', $this->record->id)
        ->update(['is_active' => false]);
    }
  }
}
