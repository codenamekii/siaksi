<?php

namespace App\Filament\Gjm\Resources\ProfilFakultasResource\Pages;

use App\Filament\Gjm\Resources\ProfilFakultasResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProfilFakultas extends ViewRecord
{
    protected static string $resource = ProfilFakultasResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }
}
