<?php

// 1. app/Filament/Ujm/Resources/GaleriKegiatanResource/Pages/EditGaleriKegiatan.php
namespace App\Filament\Ujm\Resources\GaleriKegiatanResource\Pages;

use App\Filament\Ujm\Resources\GaleriKegiatanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGaleriKegiatan extends EditRecord
{
  protected static string $resource = GaleriKegiatanResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('view')
        ->label('Lihat')
        ->icon('heroicon-o-eye')
        ->modalContent(fn() => view('filament.ujm.modals.view-galeri', ['record' => $this->record]))
        ->modalHeading($this->record->judul)
        ->modalSubmitAction(false)
        ->modalCancelActionLabel('Tutup')
        ->modalWidth('4xl'),
      Actions\DeleteAction::make(),
    ];
  }

  protected function mutateFormDataBeforeSave(array $data): array
  {
    // Handle multiple files
    if (isset($data['file_path']) && is_array($data['file_path'])) {
      $data['file_path'] = $data['file_path'][0] ?? $this->record->file_path;
    }

    return $data;
  }
}