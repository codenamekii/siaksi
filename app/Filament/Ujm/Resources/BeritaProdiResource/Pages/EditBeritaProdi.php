<?php

namespace App\Filament\Ujm\Resources\BeritaProdiResource\Pages;

use App\Filament\Ujm\Resources\BeritaProdiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBeritaProdi extends EditRecord
{
  protected static string $resource = BeritaProdiResource::class;

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
