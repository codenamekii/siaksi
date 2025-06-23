<?php

namespace App\Filament\Ujm\Resources\LaporanResource\Pages;

use App\Filament\Ujm\Resources\LaporanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLaporan extends EditRecord
{
  protected static string $resource = LaporanResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('download')
        ->label('Download Laporan')
        ->icon('heroicon-o-arrow-down-tray')
        ->color('success')
        ->url(
          fn(): string =>
          $this->record->tipe === 'file'
            ? asset('storage/' . $this->record->path)
            : $this->record->url
        )
        ->openUrlInNewTab(),
      Actions\DeleteAction::make(),
    ];
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }

  protected function mutateFormDataBeforeFill(array $data): array
  {
    // Extract periode dan tahun dari kriteria
    if (isset($data['kriteria'])) {
      $parts = explode(' ', $data['kriteria']);
      if (count($parts) >= 2) {
        $data['periode'] = $parts[0] . '_' . $parts[1];
        $data['tahun'] = $parts[2] ?? date('Y');
      }
    }

    // Extract temuan dari catatan jika ada
    if (isset($data['catatan']) && str_contains($data['catatan'], 'TEMUAN:')) {
      // Parse temuan dari catatan
      // ... logic untuk extract temuan
    }

    return $data;
  }

  protected function mutateFormDataBeforeSave(array $data): array
  {
    // Sama seperti di CreateLaporan
    if (isset($data['periode']) && isset($data['tahun'])) {
      $data['kriteria'] = $data['periode'] . ' ' . $data['tahun'];
    }

    if (isset($data['temuan']) && is_array($data['temuan'])) {
      $temuanText = "TEMUAN:\n";
      foreach ($data['temuan'] as $item) {
        $temuanText .= "- [{$item['kategori_temuan']}] {$item['temuan']}\n";
      }
      $data['catatan'] = $temuanText . "\n" . ($data['catatan'] ?? '');
      unset($data['temuan']);
    }

    unset($data['periode']);
    unset($data['tahun']);

    return $data;
  }
}
