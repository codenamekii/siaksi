<?php

namespace App\Filament\Gjm\Widgets;

use App\Models\Dokumen;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentDocuments extends BaseWidget
{
  protected static ?int $sort = 2;

  protected int | string | array $columnSpan = 'full';

  protected static ?string $heading = 'Dokumen Terbaru';

  public function table(Table $table): Table
  {
    return $table
      ->query(
        Dokumen::query()
          ->whereIn('level', ['universitas', 'fakultas'])
          ->latest()
          ->limit(5)
      )
      ->columns([
        Tables\Columns\TextColumn::make('nama')
          ->limit(40)
          ->searchable(),
        Tables\Columns\TextColumn::make('kategori')
          ->badge()
          ->formatStateUsing(fn(string $state): string => ucwords(str_replace('_', ' ', $state))),
        Tables\Columns\TextColumn::make('level')
          ->badge()
          ->color(fn(string $state): string => match ($state) {
            'universitas' => 'purple',
            'fakultas' => 'blue',
          }),
        Tables\Columns\IconColumn::make('is_visible_to_asesor')
          ->label('Asesor')
          ->boolean(),
        Tables\Columns\TextColumn::make('created_at')
          ->label('Tanggal Upload')
          ->dateTime('d M Y H:i')
          ->sortable(),
      ])
      ->actions([
        Tables\Actions\Action::make('download')
          ->icon('heroicon-m-arrow-down-tray')
          ->color('success')
          ->url(
            fn(Dokumen $record): string =>
            $record->tipe === 'file'
              ? asset('storage/' . $record->path)
              : $record->url
          )
          ->openUrlInNewTab(),
      ])
      ->paginated(false);
  }
}
