<?php

namespace App\Filament\Gjm\Resources\UserResource\Pages;

use App\Filament\Gjm\Resources\UserResource;
use App\Models\ProgramStudi;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        // Update program studi dengan UJM yang baru dibuat
        if ($this->record->program_studi_id) {
            ProgramStudi::where('id', $this->record->program_studi_id)->update(['ujm_id' => $this->record->id]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
