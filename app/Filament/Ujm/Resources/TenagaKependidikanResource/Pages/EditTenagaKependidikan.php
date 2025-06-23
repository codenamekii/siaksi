<?php

namespace App\Filament\Ujm\Resources\TenagaKependidikanResource\Pages;

use App\Filament\Ujm\Resources\TenagaKependidikanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTenagaKependidikan extends EditRecord
{
  protected static string $resource = TenagaKependidikanResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
