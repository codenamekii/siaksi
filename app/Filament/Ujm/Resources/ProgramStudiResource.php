<?php

// 1. app/Filament/Ujm/Resources/ProgramStudiResource.php
namespace App\Filament\Ujm\Resources;

use App\Filament\Ujm\Resources\ProgramStudiResource\Pages;
use App\Models\ProgramStudi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ProgramStudiResource extends Resource
{
  protected static ?string $model = ProgramStudi::class;

  protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

  protected static ?string $navigationLabel = 'Profil Program Studi';

  protected static ?string $modelLabel = 'Program Studi';

  protected static ?string $pluralModelLabel = 'Program Studi';

  protected static ?int $navigationSort = 1;

  protected static ?string $navigationGroup = 'Profil';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make('Informasi Dasar')
          ->schema([
            Forms\Components\TextInput::make('kode')
              ->label('Kode Program Studi')
              ->disabled()
              ->dehydrated(false),
            Forms\Components\TextInput::make('nama')
              ->label('Nama Program Studi')
              ->disabled()
              ->dehydrated(false),
            Forms\Components\TextInput::make('jenjang')
              ->disabled()
              ->dehydrated(false),
            Forms\Components\TextInput::make('fakultas.nama')
              ->label('Fakultas')
              ->disabled()
              ->dehydrated(false),
          ])->columns(2),

        Forms\Components\Section::make('Visi, Misi, dan Tujuan')
          ->schema([
            Forms\Components\Textarea::make('visi')
              ->rows(4)
              ->columnSpanFull(),
            Forms\Components\Textarea::make('misi')
              ->rows(6)
              ->columnSpanFull(),
            Forms\Components\Textarea::make('tujuan')
              ->rows(6)
              ->columnSpanFull(),
          ]),

        Forms\Components\Section::make('Informasi Pimpinan')
          ->schema([
            Forms\Components\TextInput::make('kaprodi')
              ->label('Kepala Program Studi')
              ->maxLength(255),
            Forms\Components\TextInput::make('email')
              ->email()
              ->maxLength(255),
            Forms\Components\TextInput::make('telepon')
              ->tel()
              ->maxLength(20),
          ])->columns(3),

        Forms\Components\Section::make('Status')
          ->schema([
            Forms\Components\Toggle::make('is_active')
              ->label('Status Aktif')
              ->disabled()
              ->dehydrated(false),
            Forms\Components\Placeholder::make('akreditasi_status')
              ->label('Status Akreditasi')
              ->content(fn($record) => $record?->akreditasiAktif
                ? $record->akreditasiAktif->status_akreditasi . ' (' . $record->akreditasiAktif->lembaga_akreditasi . ')'
                : 'Belum Terakreditasi'),
          ])->columns(2),
      ]);
  }

  public static function getNavigationGroup(): ?string
  {
    return 'Profil';
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('kode')
          ->label('Kode')
          ->badge()
          ->color('primary'),
        Tables\Columns\TextColumn::make('nama')
          ->label('Nama Program Studi')
          ->description(fn($record) => $record->jenjang . ' - ' . $record->fakultas->nama),
        Tables\Columns\TextColumn::make('kaprodi')
          ->label('Kepala Prodi')
          ->placeholder('Belum diisi'),
        Tables\Columns\TextColumn::make('akreditasiAktif.status_akreditasi')
          ->label('Akreditasi')
          ->badge()
          ->color(fn($state): string => match ($state) {
            'Unggul' => 'success',
            'Baik Sekali' => 'info',
            'Baik' => 'warning',
            default => 'gray',
          })
          ->placeholder('Belum Terakreditasi'),
        Tables\Columns\IconColumn::make('is_active')
          ->label('Status')
          ->boolean(),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make()
          ->label('Edit Profil'),
      ])
      ->bulkActions([
        //
      ])
      ->paginated(false);
  }

  public static function getEloquentQuery(): Builder
  {
    // Hanya tampilkan program studi yang dikelola oleh UJM yang login
    return parent::getEloquentQuery()
      ->where('id', Auth::user()->programStudi?->id);
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
      'index' => Pages\ListProgramStudis::route('/'),
      'edit' => Pages\EditProgramStudi::route('/{record}/edit'),
    ];
  }

  public static function canCreate(): bool
  {
    return false; // UJM tidak bisa membuat program studi baru
  }
}
