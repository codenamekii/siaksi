<?php

// 1. app/Filament/Ujm/Resources/StrukturOrganisasiResource/Pages/EditStrukturOrganisasi.php
namespace App\Filament\Ujm\Resources\StrukturOrganisasiResource\Pages;

use App\Filament\Ujm\Resources\StrukturOrganisasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditStrukturOrganisasi extends EditRecord
{
  protected static string $resource = StrukturOrganisasiResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('view')
        ->label('Lihat Gambar')
        ->icon('heroicon-o-eye')
        ->modalContent(fn() => view('filament.ujm.modals.view-struktur', ['record' => $this->record]))
        ->modalHeading('Struktur Organisasi')
        ->modalSubmitAction(false)
        ->modalCancelActionLabel('Tutup')
        ->modalWidth('7xl'),
      Actions\DeleteAction::make(),
    ];
  }

  protected function beforeSave(): void
  {
    // Jika struktur ini diset aktif, nonaktifkan yang lain
    if ($this->data['is_active']) {
      \App\Models\StrukturOrganisasi::where('program_studi_id', Auth::user()->programStudi?->id)
        ->where('id', '!=', $this->record->id)
        ->where('is_active', true)
        ->update(['is_active' => false]);
    }
  }
}
