<?php

// 1. app/Filament/Ujm/Resources/DosenResource.php
namespace App\Filament\Ujm\Resources;

use App\Filament\Ujm\Resources\DosenResource\Pages;
use App\Models\Dosen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class DosenResource extends Resource
{
  protected static ?string $model = Dosen::class;

  protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

  protected static ?string $navigationLabel = 'Data Dosen';

  protected static ?string $modelLabel = 'Dosen';

  protected static ?string $pluralModelLabel = 'Data Dosen';

  protected static ?int $navigationSort = 1;

  protected static ?string $navigationGroup = 'Data Pendukung';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make('Identitas Dosen')
          ->schema([
            Forms\Components\TextInput::make('nama')
              ->required()
              ->maxLength(255),
            Forms\Components\TextInput::make('nuptk')
              ->label('NUPTK (Nomor Unik Pendidik dan Tenaga Kependidikan)')
              ->required()
              ->unique(ignoreRecord: true)
              ->maxLength(16)
              ->placeholder('16 digit NUPTK')
              ->helperText('Nomor Unik Pendidik dan Tenaga Kependidikan'),
            Forms\Components\TextInput::make('nidn')
              ->label('NIDN/NIDK')
              ->unique(ignoreRecord: true)
              ->maxLength(10)
              ->placeholder('10 digit NIDN')
              ->helperText('Nomor Induk Dosen Nasional / Khusus'),
          ])->columns(3),

        Forms\Components\Section::make('Informasi Akademik')
          ->schema([
            Forms\Components\Select::make('jabatan_akademik')
              ->options([
                'Asisten Ahli' => 'Asisten Ahli',
                'Lektor' => 'Lektor',
                'Lektor Kepala' => 'Lektor Kepala',
                'Profesor' => 'Profesor',
                'Tenaga Pengajar' => 'Tenaga Pengajar',
              ])
              ->placeholder('Pilih jabatan akademik'),
            Forms\Components\Select::make('pendidikan_terakhir')
              ->options([
                'S1' => 'S1 - Sarjana',
                'S2' => 'S2 - Magister',
                'S3' => 'S3 - Doktor',
                'Profesi' => 'Profesi',
                'Sp-1' => 'Spesialis-1',
                'Sp-2' => 'Spesialis-2',
              ])
              ->placeholder('Pilih pendidikan terakhir'),
            Forms\Components\TextInput::make('bidang_keahlian')
              ->maxLength(255)
              ->placeholder('Contoh: Rekayasa Perangkat Lunak'),
          ])->columns(3),

        Forms\Components\Section::make('Kontak')
          ->schema([
            Forms\Components\TextInput::make('email')
              ->email()
              ->maxLength(255),
            Forms\Components\TextInput::make('telepon')
              ->tel()
              ->maxLength(20)
              ->placeholder('Contoh: 081234567890'),
            Forms\Components\Toggle::make('is_active')
              ->label('Status Aktif')
              ->default(true)
              ->helperText('Dosen aktif akan ditampilkan dalam laporan'),
            Forms\Components\Hidden::make('program_studi_id')
              ->default(fn() => Auth::user()->programStudi?->id),
          ])->columns(3),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('nama')
          ->searchable()
          ->sortable(),
        Tables\Columns\TextColumn::make('nuptk')
          ->label('NUPTK')
          ->searchable()
          ->copyable()
          ->copyMessage('NUPTK disalin!')
          ->tooltip('Nomor Unik Pendidik dan Tenaga Kependidikan'),
        Tables\Columns\TextColumn::make('nidn')
          ->label('NIDN/NIDK')
          ->searchable()
          ->placeholder('Belum ada')
          ->toggleable(),
        Tables\Columns\TextColumn::make('jabatan_akademik')
          ->label('Jabatan')
          ->badge()
          ->color(fn(string $state): string => match ($state) {
            'Profesor' => 'danger',
            'Lektor Kepala' => 'warning',
            'Lektor' => 'info',
            'Asisten Ahli' => 'success',
            default => 'gray',
          })
          ->placeholder('Belum diisi'),
        Tables\Columns\TextColumn::make('pendidikan_terakhir')
          ->label('Pendidikan')
          ->badge()
          ->color(fn(string $state): string => match ($state) {
            'S3' => 'danger',
            'S2' => 'warning',
            'S1' => 'info',
            default => 'gray',
          })
          ->placeholder('Belum diisi'),
        Tables\Columns\TextColumn::make('bidang_keahlian')
          ->label('Keahlian')
          ->searchable()
          ->limit(30)
          ->toggleable(),
        Tables\Columns\TextColumn::make('email')
          ->copyable()
          ->toggleable(),
        Tables\Columns\IconColumn::make('is_active')
          ->label('Status')
          ->boolean(),
      ])
      ->filters([
        Tables\Filters\SelectFilter::make('jabatan_akademik')
          ->options([
            'Asisten Ahli' => 'Asisten Ahli',
            'Lektor' => 'Lektor',
            'Lektor Kepala' => 'Lektor Kepala',
            'Profesor' => 'Profesor',
            'Tenaga Pengajar' => 'Tenaga Pengajar',
          ]),
        Tables\Filters\SelectFilter::make('pendidikan_terakhir')
          ->options([
            'S1' => 'S1',
            'S2' => 'S2',
            'S3' => 'S3',
          ]),
        Tables\Filters\TernaryFilter::make('is_active')
          ->label('Status Aktif'),
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
          Tables\Actions\BulkAction::make('setActive')
            ->label('Set Aktif')
            ->icon('heroicon-o-check')
            ->color('success')
            ->requiresConfirmation()
            ->action(fn($records) => $records->each->update(['is_active' => true]))
            ->deselectRecordsAfterCompletion(),
          Tables\Actions\BulkAction::make('setInactive')
            ->label('Set Non-Aktif')
            ->icon('heroicon-o-x-mark')
            ->color('danger')
            ->requiresConfirmation()
            ->action(fn($records) => $records->each->update(['is_active' => false]))
            ->deselectRecordsAfterCompletion(),
        ]),
      ])
      ->defaultSort('nama', 'asc');
  }

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()
      ->where('program_studi_id', Auth::user()->programStudi?->id);
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
      'index' => Pages\ListDosens::route('/'),
      'create' => Pages\CreateDosen::route('/create'),
      'edit' => Pages\EditDosen::route('/{record}/edit'),
    ];
  }

  public static function getNavigationBadge(): ?string
  {
    return static::getEloquentQuery()
      ->where('is_active', true)
      ->count();
  }
}