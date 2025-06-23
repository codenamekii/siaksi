<?php

namespace App\Filament\Gjm\Resources\BeritaResource\Pages;

use App\Filament\Gjm\Resources\BeritaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBerita extends EditRecord
{
  protected static string $resource = BeritaResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('publish')
        ->label('Publikasikan')
        ->icon('heroicon-o-check-circle')
        ->color('success')
        ->visible(fn() => !$this->record->is_published)
        ->requiresConfirmation()
        ->action(function () {
          $this->record->update([
            'is_published' => true,
            'tanggal_publikasi' => now(),
          ]);
        }),
      Actions\DeleteAction::make(),
    ];
  }
}
