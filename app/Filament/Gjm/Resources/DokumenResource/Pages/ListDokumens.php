<?php

namespace App\Filament\Gjm\Resources\DokumenResource\Pages;

use App\Filament\Gjm\Resources\DokumenResource;
use App\Models\Dokumen;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListDokumens extends ListRecords
{
    protected static string $resource = DokumenResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()->label('Upload Dokumen Baru')];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua'),
            'kebijakan' => Tab::make('Kebijakan')->modifyQueryUsing(fn(Builder $query) => $query->where('kategori', 'kebijakan_mutu')),
            'standar' => Tab::make('Standar')->modifyQueryUsing(fn(Builder $query) => $query->where('kategori', 'standar_mutu')),
            'laporan' => Tab::make('Laporan')->modifyQueryUsing(fn(Builder $query) => $query->where('kategori', 'laporan_ami')),
            'visible_asesor' => Tab::make('Terlihat Asesor')->modifyQueryUsing(fn(Builder $query) => $query->where('is_visible_to_asesor', true))->badge(fn() => Dokumen::where('is_visible_to_asesor', true)->count()),
        ];
    }
}
