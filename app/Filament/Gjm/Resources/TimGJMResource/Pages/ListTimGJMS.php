<?php
// Lokasi file: app/Filament/Gjm/Resources/TimGJMResource/Pages/ListTimGJMS.php

namespace App\Filament\Gjm\Resources\TimGJMResource\Pages;

use App\Filament\Gjm\Resources\TimGJMResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimGJMS extends ListRecords
{
  protected static string $resource = TimGJMResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }

  // REMOVED getHeaderWidgets() or getFooterWidgets() that was calling the non-existent widget
}