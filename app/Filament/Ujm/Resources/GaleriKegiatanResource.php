<?php

// 1. app/Filament/Ujm/Resources/GaleriKegiatanResource.php
namespace App\Filament\Ujm\Resources;

use App\Filament\Ujm\Resources\GaleriKegiatanResource\Pages;
use App\Models\GaleriKegiatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Auth;

class GaleriKegiatanResource extends Resource
{
  protected static ?string $model = GaleriKegiatan::class;

  protected static ?string $navigationIcon = 'heroicon-o-photo';

  protected static ?string $navigationLabel = 'Dokumentasi Kegiatan';

  protected static ?string $modelLabel = 'Dokumentasi';

  protected static ?string $pluralModelLabel = 'Dokumentasi Kegiatan';

  protected static ?int $navigationSort = 6;

  protected static ?string $navigationGroup = 'Konten';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make('Informasi Kegiatan')
          ->schema([
            Forms\Components\TextInput::make('judul')
              ->required()
              ->maxLength(255),
            Forms\Components\Textarea::make('deskripsi')
              ->rows(3)
              ->maxLength(500),
            Forms\Components\DatePicker::make('tanggal_kegiatan')
              ->required()
              ->native(false)
              ->maxDate(now()),
            Forms\Components\Hidden::make('program_studi_id')
              ->default(fn() => Auth::user()->programStudi?->id),
          ])->columns(1),

        Forms\Components\Section::make('Upload Media')
          ->schema([
            Forms\Components\Select::make('tipe')
              ->options([
                'foto' => 'Foto',
                'video' => 'Video (YouTube/Embed)',
              ])
              ->default('foto')
              ->required()
              ->reactive(),
            Forms\Components\FileUpload::make('file_path')
              ->label('Upload Foto')
              ->image()
              ->multiple()
              ->directory(fn() => 'galeri/' . Auth::user()->programStudi?->kode)
              ->maxSize(5120)
              ->imageResizeMode('contain')
              ->imageResizeTargetWidth('1920')
              ->imageResizeTargetHeight('1080')
              ->helperText('Upload foto kegiatan. Format: JPG, PNG. Maksimal 5MB per file')
              ->visible(fn(Get $get) => $get('tipe') === 'foto')
              ->required(fn(Get $get) => $get('tipe') === 'foto'),
            Forms\Components\TextInput::make('video_url')
              ->label('URL Video')
              ->url()
              ->helperText('Masukkan URL YouTube atau embed code')
              ->placeholder('https://www.youtube.com/watch?v=...')
              ->visible(fn(Get $get) => $get('tipe') === 'video')
              ->required(fn(Get $get) => $get('tipe') === 'video'),
          ])->columns(1),

        Forms\Components\Section::make('Pengaturan')
          ->schema([
            Forms\Components\Toggle::make('is_active')
              ->label('Tampilkan di Galeri')
              ->default(true),
          ]),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\ImageColumn::make('file_path')
        ->label('Preview')
        ->square()
        ->size(80)
        ->visibility('private')
        ->getStateUsing(fn($record) => $record->tipe === 'foto'
          ? $record->file_path[0] ?? 'https://via.placeholder.com/150x150?text=No+Image'
          : 'https://via.placeholder.com/150x150?text=Video'),
        Tables\Columns\TextColumn::make('judul')
          ->searchable()
          ->limit(40),
        Tables\Columns\TextColumn::make('tipe')
          ->badge()
          ->color(fn(string $state): string => match ($state) {
            'foto' => 'success',
            'video' => 'warning',
          }),
        Tables\Columns\TextColumn::make('tanggal_kegiatan')
          ->date('d M Y')
          ->sortable(),
        Tables\Columns\IconColumn::make('is_active')
          ->label('Status')
          ->boolean()
          ->trueIcon('heroicon-o-eye')
          ->falseIcon('heroicon-o-eye-slash')
          ->trueColor('success')
          ->falseColor('gray'),
        Tables\Columns\TextColumn::make('created_at')
          ->label('Diupload')
          ->dateTime('d M Y')
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->filters([
        Tables\Filters\SelectFilter::make('tipe')
          ->options([
            'foto' => 'Foto',
            'video' => 'Video',
          ]),
        Tables\Filters\TernaryFilter::make('is_active')
          ->label('Status Aktif'),
      ])
      ->actions([
        Tables\Actions\Action::make('view')
          ->label('Lihat')
          ->icon('heroicon-o-eye')
          ->modalContent(fn($record) => view('filament.ujm.modals.view-galeri', ['record' => $record]))
          ->modalHeading(fn($record) => $record->judul)
          ->modalSubmitAction(false)
          ->modalCancelActionLabel('Tutup')
          ->modalWidth('4xl'),
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
          Tables\Actions\BulkAction::make('toggleActive')
            ->label('Toggle Status Aktif')
            ->icon('heroicon-o-eye')
            ->requiresConfirmation()
            ->action(fn($records) => $records->each(function ($record) {
              $record->update([
                'is_active' => !$record->is_active
              ]);
            }))
            ->deselectRecordsAfterCompletion(),
        ]),
      ])
      ->defaultSort('tanggal_kegiatan', 'desc');
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
      'index' => Pages\ListGaleriKegiatans::route('/'),
      'create' => Pages\CreateGaleriKegiatan::route('/create'),
      'edit' => Pages\EditGaleriKegiatan::route('/{record}/edit'),
    ];
  }
}