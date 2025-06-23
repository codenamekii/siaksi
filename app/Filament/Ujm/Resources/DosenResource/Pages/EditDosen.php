<?php

// 1. app/Filament/Ujm/Resources/DosenResource/Pages/EditDosen.php
namespace App\Filament\Ujm\Resources\DosenResource\Pages;

use App\Filament\Ujm\Resources\DosenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDosen extends EditRecord
{
  protected static string $resource = DosenResource::class;

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