<?php

namespace App\Filament\Gjm\Resources\UserResource\Pages;

use App\Filament\Gjm\Resources\UserResource;
use App\Models\ProgramStudi;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->before(function ($record) {
                if ($record->programStudi) {
                    $record->programStudi->update(['ujm_id' => null]);
                }
            }),
        ];
    }

    protected function afterSave(): void
    {
        // Update program studi UJM jika berubah
        if ($this->record->program_studi_id) {
            // Reset UJM lama jika ada
            ProgramStudi::where('ujm_id', $this->record->id)
                ->where('id', '!=', $this->record->program_studi_id)
                ->update(['ujm_id' => null]);

            // Set UJM baru
            ProgramStudi::where('id', $this->record->program_studi_id)->update(['ujm_id' => $this->record->id]);
        }
    }
}
