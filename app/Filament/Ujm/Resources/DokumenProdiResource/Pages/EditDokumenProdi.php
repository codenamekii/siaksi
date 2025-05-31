<?php

namespace App\Filament\Ujm\Resources\DokumenProdiResource\Pages;

use App\Filament\Ujm\Resources\DokumenProdiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDokumenProdi extends EditRecord
{
  protected static string $resource = DokumenProdiResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('download')
        ->label('Download')
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
}
