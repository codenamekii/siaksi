<?php

namespace App\Filament\Gjm\Resources\JadwalAMIResource\Pages;

use App\Filament\Gjm\Resources\JadwalAMIResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJadwalAMI extends EditRecord
{
  protected static string $resource = JadwalAMIResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }
}
