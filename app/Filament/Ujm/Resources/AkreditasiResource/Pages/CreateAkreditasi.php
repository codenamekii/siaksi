<?php

// 1. app/Filament/Ujm/Resources/AkreditasiResource/Pages/CreateAkreditasi.php
namespace App\Filament\Ujm\Resources\AkreditasiResource\Pages;

use App\Filament\Ujm\Resources\AkreditasiResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\AkreditasiProdi;
use Illuminate\Support\Facades\Auth;

class CreateAkreditasi extends CreateRecord
{
  protected static string $resource = AkreditasiResource::class;

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }

  protected function beforeCreate(): void
  {
    // Jika akreditasi ini diset aktif, nonaktifkan yang lain
    if ($this->data['is_active'] ?? false) {
      AkreditasiProdi::where('program_studi_id', Auth::user()->programStudi?->id)
        ->update(['is_active' => false]);
    }
  }
}