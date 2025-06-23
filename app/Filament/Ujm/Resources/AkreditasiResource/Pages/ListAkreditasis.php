<?php

namespace App\Filament\Ujm\Resources\AkreditasiResource\Pages;

use App\Filament\Ujm\Resources\AkreditasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAkreditasis extends ListRecords
{
  protected static string $resource = AkreditasiResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make()
        ->label('Tambah Akreditasi Baru'),
    ];
  }

  protected function getHeaderWidgets(): array
  {
    return [
      AkreditasiResource\Widgets\CurrentAkreditasiWidget::class,
    ];
  }
}
