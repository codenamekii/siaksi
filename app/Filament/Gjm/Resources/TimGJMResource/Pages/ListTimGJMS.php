<?php

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
      Actions\CreateAction::make()
        ->label('Tambah Anggota Tim'),
    ];
  }

  protected function getHeaderWidgets(): array
  {
    return [
      TimGJMResource\Widgets\TimGJMOverview::class,
    ];
  }
}
