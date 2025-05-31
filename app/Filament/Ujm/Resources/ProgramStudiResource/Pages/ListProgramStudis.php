<?php

namespace App\Filament\Ujm\Resources\ProgramStudiResource\Pages;

use App\Filament\Ujm\Resources\ProgramStudiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProgramStudis extends ListRecords
{
  protected static string $resource = ProgramStudiResource::class;

  protected function getHeaderActions(): array
  {
    return [
      //
    ];
  }

  protected function getHeaderWidgets(): array
  {
    return [
      // ProgramStudiResource\Widgets\ProgramStudiOverview::class,
    ];
  }
}
