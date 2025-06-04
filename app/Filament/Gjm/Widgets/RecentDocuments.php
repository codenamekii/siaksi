<?php

namespace App\Filament\Gjm\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Dokumen;

class RecentDocuments extends BaseWidget
{
  protected static ?int $sort = 4;

  protected int | string | array $columnSpan = 'full';

  public function table(Table $table): Table
  {
    return $table
      ->query(
        Dokumen::query()
          ->where('level', 'fakultas')
          ->latest()
          ->limit(5)
      )
      ->columns([
        Tables\Columns\TextColumn::make('nama')
          ->label('Nama Dokumen')
          ->searchable()
          ->limit(50),
        Tables\Columns\TextColumn::make('kategori')
          ->badge()
          ->formatStateUsing(fn(string $state): string => match ($state) {
            'kebijakan_mutu' => 'Kebijakan Mutu',
            'standar_mutu' => 'Standar Mutu',
            'laporan_ami' => 'Laporan AMI',
            'prosedur' => 'Prosedur',
            'instrumen' => 'Instrumen',
            default => ucwords(str_replace('_', ' ', $state)),
          })
          ->color(fn(string $state): string => match ($state) {
            'kebijakan_mutu' => 'info',
            'standar_mutu' => 'success',
            'laporan_ami' => 'warning',
            'prosedur' => 'primary',
            'instrumen' => 'gray',
            default => 'secondary',
          }),
        Tables\Columns\TextColumn::make('created_at')
          ->label('Tanggal Upload')
          ->dateTime('d M Y')
          ->sortable(),
        Tables\Columns\IconColumn::make('is_visible_to_asesor')
          ->label('Visible')
          ->boolean()
          ->trueIcon('heroicon-o-eye')
          ->falseIcon('heroicon-o-eye-slash')
          ->trueColor('success')
          ->falseColor('danger'),
      ])
      ->paginated(false);
  }
}
