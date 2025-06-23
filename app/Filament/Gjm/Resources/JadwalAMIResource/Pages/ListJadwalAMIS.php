<?php

namespace App\Filament\Gjm\Resources\JadwalAMIResource\Pages;

use App\Filament\Gjm\Resources\JadwalAMIResource;
use App\Filament\Gjm\Widgets\JadwalAMICalendar; // Fixed: AMI with capital letters
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJadwalAMIS extends ListRecords
{
    protected static string $resource = JadwalAMIResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            JadwalAMICalendar::class, // Fixed: AMI with capital letters
        ];
    }

    public function getTitle(): string
    {
        return 'Jadwal AMI';
    }
}
