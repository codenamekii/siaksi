<?php

// Lokasi file: app/Filament/Gjm/Resources/TimGJMResource.php
namespace App\Filament\Gjm\Resources;

use App\Filament\Gjm\Resources\TimGJMResource\Pages;
use App\Models\TimGJM;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TimGJMResource extends Resource
{
  protected static ?string $model = TimGJM::class;

  protected static ?string $navigationIcon = 'heroicon-o-user-group';

  protected static ?string $navigationLabel = 'Tim GJM';

  protected static ?string $modelLabel = 'Anggota Tim GJM';

  protected static ?string $pluralModelLabel = 'Tim GJM';

  protected static ?int $navigationSort = 5;

  protected static ?string $navigationGroup = 'Organisasi';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make('Informasi Anggota')
          ->schema([
            Forms\Components\TextInput::make('nama')
              ->required()
              ->maxLength(255),
            Forms\Components\TextInput::make('jabatan')
              ->required()
              ->maxLength(255)
              ->placeholder('Contoh: Ketua GJM, Sekretaris GJM'),
            Forms\Components\TextInput::make('nuptk')
              ->label('NUPTK')
              ->maxLength(20)
              ->placeholder('NUPTK'),
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
          ])->columns(2),

        Forms\Components\Section::make('Foto & Pengaturan')
          ->schema([
            Forms\Components\FileUpload::make('foto')
              ->image()
              ->directory('tim-gjm')
              ->maxSize(2048)
              ->imageResizeMode('cover')
              ->imageCropAspectRatio('1:1')
              ->imageResizeTargetWidth('500')
              ->imageResizeTargetHeight('500')
              ->helperText('Foto akan di-crop menjadi persegi. Maksimal 2MB'),
            Forms\Components\TextInput::make('urutan')
              ->numeric()
              ->default(0)
              ->helperText('Urutan tampilan (0 = paling atas)'),
            Forms\Components\Toggle::make('is_active')
              ->label('Status Aktif')
              ->default(true),
            Forms\Components\Hidden::make('fakultas_id')
              ->default(1), // Default fakultas ID
          ])->columns(3),
      ]);
  }

  // REMOVED getWidgets() method that was causing the error

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('urutan')
          ->label('No')
          ->sortable()
          ->width('50px'),
        Tables\Columns\ImageColumn::make('foto')
          ->circular()
          ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->nama))
          ->width('60px')
          ->height('60px'),
        Tables\Columns\TextColumn::make('nama')
          ->searchable()
          ->sortable(),
        Tables\Columns\TextColumn::make('jabatan')
          ->searchable()
          ->badge()
          ->color(fn(string $state): string => match (true) {
            str_contains(strtolower($state), 'ketua') => 'danger',
            str_contains(strtolower($state), 'sekretaris') => 'warning',
            str_contains(strtolower($state), 'koordinator') => 'info',
            default => 'gray',
          }),
        Tables\Columns\TextColumn::make('nuptk')
          ->label('NUPTK')
          ->searchable()
          ->toggleable(),
        Tables\Columns\TextColumn::make('email')
          ->copyable()
          ->copyMessage('Email disalin!')
          ->toggleable(),
        Tables\Columns\TextColumn::make('telepon')
          ->copyable()
          ->toggleable(),
        Tables\Columns\IconColumn::make('is_active')
          ->label('Status')
          ->boolean(),
      ])
      ->filters([
        Tables\Filters\TernaryFilter::make('is_active')
          ->label('Status Aktif'),
      ])
      ->actions([
        Tables\Actions\Action::make('moveUp')
          ->label('')
          ->icon('heroicon-o-chevron-up')
          ->color('gray')
          ->action(function (TimGJM $record): void {
            $record->moveOrderUp();
          }),
        Tables\Actions\Action::make('moveDown')
          ->label('')
          ->icon('heroicon-o-chevron-down')
          ->color('gray')
          ->action(function (TimGJM $record): void {
            $record->moveOrderDown();
          }),
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ])
      ->defaultSort('urutan', 'asc')
      ->reorderable('urutan');
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
      'index' => Pages\ListTimGJMS::route('/'),
      'create' => Pages\CreateTimGJM::route('/create'),
      'edit' => Pages\EditTimGJM::route('/{record}/edit'),
    ];
  }
}