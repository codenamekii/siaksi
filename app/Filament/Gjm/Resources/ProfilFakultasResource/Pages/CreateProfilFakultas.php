<?php

namespace App\Filament\Gjm\Resources\ProfilFakultasResource\Pages;

use App\Filament\Gjm\Resources\ProfilFakultasResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProfilFakultas extends CreateRecord
{
    protected static string $resource = ProfilFakultasResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
