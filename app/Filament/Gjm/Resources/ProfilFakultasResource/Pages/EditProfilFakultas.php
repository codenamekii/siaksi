<?php

namespace App\Filament\Gjm\Resources\ProfilFakultasResource\Pages;

use App\Filament\Gjm\Resources\ProfilFakultasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProfilFakultas extends EditRecord
{
    protected static string $resource = ProfilFakultasResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\ViewAction::make(), Actions\DeleteAction::make()];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
