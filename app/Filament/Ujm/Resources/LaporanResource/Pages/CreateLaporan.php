<?php

namespace App\Filament\Ujm\Resources\LaporanResource\Pages;

use App\Filament\Ujm\Resources\LaporanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLaporan extends CreateRecord
{
  protected static string $resource = LaporanResource::class;

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    // Simpan periode dan tahun sebagai metadata
    if (isset($data['periode']) && isset($data['tahun'])) {
      $data['kriteria'] = $data['periode'] . ' ' . $data['tahun'];
    }

    // Simpan temuan sebagai JSON di field catatan jika ada
    if (isset($data['temuan']) && is_array($data['temuan'])) {
      $temuanText = "TEMUAN:\n";
      foreach ($data['temuan'] as $item) {
        $temuanText .= "- [{$item['kategori_temuan']}] {$item['temuan']}\n";
      }
      $data['catatan'] = $temuanText . "\n" . ($data['catatan'] ?? '');
      unset($data['temuan']);
    }

    // Hapus field yang tidak ada di tabel dokumen
    unset($data['periode']);
    unset($data['tahun']);

    return $data;
  }
}
