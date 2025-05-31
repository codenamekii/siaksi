<?php

// 1. app/Filament/Ujm/Resources/StrukturOrganisasiResource.php
namespace App\Filament\Ujm\Resources;

use App\Filament\Ujm\Resources\StrukturOrganisasiResource\Pages;
use App\Models\StrukturOrganisasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class StrukturOrganisasiResource extends Resource
{
  protected static ?string $model = StrukturOrganisasi::class;

  protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

  protected static ?string $navigationLabel = 'Struktur Organisasi';

  protected static ?string $modelLabel = 'Struktur Organisasi';

  protected static ?string $pluralModelLabel = 'Struktur Organisasi';

  protected static ?int $navigationSort = 1;

  protected static ?string $navigationGroup = 'Profil';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make('Upload Struktur Organisasi')
          ->schema([
            Forms\Components\TextInput::make('judul')
              ->required()
              ->maxLength(255)
              ->default('Struktur Organisasi Program Studi'),
            Forms\Components\Textarea::make('deskripsi')
              ->rows(3)
              ->maxLength(500)
              ->helperText('Deskripsi singkat tentang struktur organisasi'),
            Forms\Components\FileUpload::make('gambar')
              ->required()
              ->image()
              ->directory(fn() => 'struktur/prodi/' . Auth::user()->programStudi?->kode)
              ->maxSize(5120)
              ->imageResizeMode('contain')
              ->imageResizeTargetWidth('1920')
              ->imageResizeTargetHeight('1080')
              ->helperText('Upload gambar struktur organisasi. Format: JPG, PNG. Maksimal 5MB')
              ->columnSpanFull(),
            Forms\Components\Toggle::make('is_active')
              ->label('Status Aktif')
              ->default(true)
              ->helperText('Hanya struktur organisasi aktif yang akan ditampilkan'),
            Forms\Components\Hidden::make('level')
              ->default('prodi'),
            Forms\Components\Hidden::make('program_studi_id')
              ->default(fn() => Auth::user()->programStudi?->id),
          ])->columns(2),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\ImageColumn::make('gambar')
          ->label('Preview')
          ->width(150)
          ->height(100),
        Tables\Columns\TextColumn::make('judul')
          ->searchable(),
        Tables\Columns\TextColumn::make('deskripsi')
          ->limit(50)
          ->toggleable(),
        Tables\Columns\IconColumn::make('is_active')
          ->label('Status')
          ->boolean()
          ->trueIcon('heroicon-o-check-circle')
          ->falseIcon('heroicon-o-x-circle')
          ->trueColor('success')
          ->falseColor('danger'),
        Tables\Columns\TextColumn::make('created_at')
          ->label('Tanggal Upload')
          ->dateTime('d M Y')
          ->sortable(),
      ])
      ->filters([
        Tables\Filters\TernaryFilter::make('is_active')
          ->label('Status Aktif'),
      ])
      ->actions([
        Tables\Actions\Action::make('view')
          ->label('Lihat')
          ->icon('heroicon-o-eye')
          ->modalContent(fn($record) => view('filament.ujm.modals.view-struktur', ['record' => $record]))
          ->modalHeading('Struktur Organisasi')
          ->modalSubmitAction(false)
          ->modalCancelActionLabel('Tutup'),
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ])
      ->defaultSort('created_at', 'desc');
  }

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()
      ->where('level', 'prodi')
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
      'index' => Pages\ListStrukturOrganisasis::route('/'),
      'create' => Pages\CreateStrukturOrganisasi::route('/create'),
      'edit' => Pages\EditStrukturOrganisasi::route('/{record}/edit'),
    ];
  }
}