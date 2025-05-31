<?php

namespace App\Filament\Gjm\Resources\DokumenResource\Pages;

use App\Filament\Gjm\Resources\DokumenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDokumen extends EditRecord
{
    protected static string $resource = DokumenResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\Action::make('download')->label('Download')->icon('heroicon-o-arrow-down-tray')->color('success')->url(fn(): string => $this->record->tipe === 'file' ? asset('storage/' . $this->record->path) : $this->record->url)->openUrlInNewTab(), Actions\DeleteAction::make()];
    }
}
