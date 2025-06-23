<?php

namespace App\Filament\Ujm\Resources\TimUJMResource\Pages;

use App\Filament\Ujm\Resources\TimUJMResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimUJMS extends ListRecords
{
  protected static string $resource = TimUJMResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make()
        ->label('Tambah Anggota Tim'),
    ];
  }
}
