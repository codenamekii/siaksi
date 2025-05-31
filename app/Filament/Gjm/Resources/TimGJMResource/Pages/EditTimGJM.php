<?php

namespace App\Filament\Gjm\Resources\TimGJMResource\Pages;

use App\Filament\Gjm\Resources\TimGJMResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTimGJM extends EditRecord
{
    protected static string $resource = TimGJMResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
