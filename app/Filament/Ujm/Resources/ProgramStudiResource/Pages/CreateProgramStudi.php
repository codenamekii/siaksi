<?php

namespace App\Filament\Ujm\Resources\ProgramStudiResource\Pages;

use App\Filament\Ujm\Resources\ProgramStudiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProgramStudi extends CreateRecord
{
  protected static string $resource = ProgramStudiResource::class;

  // Gunakan ini untuk ubah label judul halaman (opsional)
  public static function getLabel(): string
  {
    return 'Tambah Program Studi';
  }

  // Optional: manipulasi data sebelum disimpan
  protected function mutateFormDataBeforeCreate(array $data): array
  {
    return $data;
  }

  // Optional: aksi setelah simpan
  protected function afterCreate(): void
  {
    // contoh: log atau notifikasi
  }

  // Optional: redirect ke halaman index setelah create
  protected function getRedirectUrl(): string
  {
    return static::$resource::getUrl('index');
  }
}
