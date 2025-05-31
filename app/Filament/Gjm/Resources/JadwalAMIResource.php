<?php

namespace App\Filament\Gjm\Resources;

use App\Filament\Gjm\Resources\JadwalAMIResource\Pages;
use App\Models\JadwalAMI;
use App\Models\ProgramStudi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class JadwalAMIResource extends Resource
{
  protected static ?string $model = JadwalAMI::class;

  protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

  protected static ?string $navigationLabel = 'Jadwal AMI';

  protected static ?string $modelLabel = 'Jadwal AMI';

  protected static ?string $pluralModelLabel = 'Jadwal AMI';

  protected static ?int $navigationSort = 4;

  protected static ?string $navigationGroup = 'Audit Mutu Internal';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make('Informasi Kegiatan')
          ->schema([
            Forms\Components\TextInput::make('nama_kegiatan')
              ->required()
              ->maxLength(255),
            Forms\Components\Textarea::make('deskripsi')
              ->rows(3)
              ->maxLength(500),
            Forms\Components\Select::make('program_studi_id')
              ->label('Program Studi')
              ->options(ProgramStudi::where('is_active', true)->pluck('nama', 'id'))
              ->searchable()
              ->placeholder('Pilih untuk AMI Prodi (Opsional)')
              ->helperText('Kosongkan jika AMI untuk tingkat Fakultas'),
            Forms\Components\Hidden::make('fakultas_id')
              ->default(1), // Default fakultas ID
          ])->columns(1),

        Forms\Components\Section::make('Jadwal Pelaksanaan')
          ->schema([
            Forms\Components\DatePicker::make('tanggal_mulai')
              ->required()
              ->native(false)
              ->minDate(now())
              ->reactive()
              ->afterStateUpdated(
                fn($state, Forms\Set $set) =>
                $set('tanggal_selesai', $state)
              ),
            Forms\Components\DatePicker::make('tanggal_selesai')
              ->required()
              ->native(false)
              ->minDate(fn(Forms\Get $get) => $get('tanggal_mulai') ?: now())
              ->afterOrEqual('tanggal_mulai'),
            Forms\Components\TextInput::make('tempat')
              ->maxLength(255)
              ->placeholder('Contoh: Ruang Rapat Dekanat'),
            Forms\Components\Select::make('status')
              ->options([
                'scheduled' => 'Terjadwal',
                'ongoing' => 'Sedang Berlangsung',
                'completed' => 'Selesai',
                'cancelled' => 'Dibatalkan',
              ])
              ->default('scheduled')
              ->required(),
          ])->columns(2),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('nama_kegiatan')
          ->searchable()
          ->limit(40),
        Tables\Columns\TextColumn::make('programStudi.nama')
          ->label('Program Studi')
          ->placeholder('Tingkat Fakultas')
          ->badge()
          ->color('info'),
        Tables\Columns\TextColumn::make('tanggal_mulai')
          ->date('d M Y')
          ->sortable(),
        Tables\Columns\TextColumn::make('tanggal_selesai')
          ->date('d M Y')
          ->sortable(),
        Tables\Columns\TextColumn::make('tempat')
          ->searchable()
          ->toggleable(),
        Tables\Columns\TextColumn::make('status')
          ->badge()
          ->color(fn(string $state): string => match ($state) {
            'scheduled' => 'warning',
            'ongoing' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
          })
          ->formatStateUsing(fn(string $state): string => match ($state) {
            'scheduled' => 'Terjadwal',
            'ongoing' => 'Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
          }),
        Tables\Columns\TextColumn::make('durasi')
          ->label('Durasi')
          ->getStateUsing(function ($record) {
            $start = Carbon::parse($record->tanggal_mulai);
            $end = Carbon::parse($record->tanggal_selesai);
            $days = $start->diffInDays($end) + 1;
            return $days . ' hari';
          })
          ->toggleable(),
      ])
      ->filters([
        Tables\Filters\SelectFilter::make('status')
          ->options([
            'scheduled' => 'Terjadwal',
            'ongoing' => 'Sedang Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
          ]),
        Tables\Filters\SelectFilter::make('program_studi_id')
          ->label('Program Studi')
          ->options(ProgramStudi::where('is_active', true)->pluck('nama', 'id'))
          ->placeholder('Semua (Termasuk Fakultas)'),
        Tables\Filters\Filter::make('upcoming')
          ->label('Akan Datang')
          ->query(fn(Builder $query): Builder => $query->where('tanggal_mulai', '>=', now())),
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\Action::make('updateStatus')
          ->label('Update Status')
          ->icon('heroicon-o-arrow-path')
          ->color('warning')
          ->form([
            Forms\Components\Select::make('status')
              ->options([
                'scheduled' => 'Terjadwal',
                'ongoing' => 'Sedang Berlangsung',
                'completed' => 'Selesai',
                'cancelled' => 'Dibatalkan',
              ])
              ->required(),
          ])
          ->action(function (array $data, JadwalAMI $record): void {
            $record->update(['status' => $data['status']]);
          }),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ])
      ->defaultSort('tanggal_mulai', 'asc');
  }

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListJadwalAMIS::route('/'),
      'create' => Pages\CreateJadwalAMI::route('/create'),
      'edit' => Pages\EditJadwalAMI::route('/{record}/edit'),
    ];
  }

  public static function getNavigationBadge(): ?string
  {
    return static::getModel()::where('status', 'scheduled')
      ->where('tanggal_mulai', '>=', now())
      ->count();
  }

  public static function getNavigationBadgeColor(): ?string
  {
    return 'warning';
  }
}
