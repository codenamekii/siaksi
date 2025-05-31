<?php

namespace App\Filament\Ujm\Resources\AkreditasiResource\Pages;

use App\Filament\Ujm\Resources\AkreditasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAkreditasi extends EditRecord
{
    protected static string $resource = AkreditasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
