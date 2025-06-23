<?php

namespace App\Filament\Ujm\Resources\TimUJMResource\Pages;

use App\Filament\Ujm\Resources\TimUJMResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTimUJM extends EditRecord
{
  protected static string $resource = TimUJMResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }
}
