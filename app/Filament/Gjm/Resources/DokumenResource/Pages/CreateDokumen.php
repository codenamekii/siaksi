<?php

namespace App\Filament\Gjm\Resources\DokumenResource\Pages;

use App\Filament\Gjm\Resources\DokumenResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDokumen extends CreateRecord
{
    protected static string $resource = DokumenResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
