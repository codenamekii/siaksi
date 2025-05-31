<?php

namespace App\Filament\Ujm\Resources\StrukturOrganisasiResource\Pages;

use App\Filament\Ujm\Resources\StrukturOrganisasiResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateStrukturOrganisasi extends CreateRecord
{
  protected static string $resource = StrukturOrganisasiResource::class;

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }

  protected function beforeCreate(): void
  {
    // Set struktur organisasi lama menjadi tidak aktif
    \App\Models\StrukturOrganisasi::where('program_studi_id', Auth::user()->programStudi?->id)
      ->where('is_active', true)
      ->update(['is_active' => false]);
  }
}
