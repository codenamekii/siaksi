<?php

// 1. app/Filament/Ujm/Resources/DokumenProdiResource.php
namespace App\Filament\Ujm\Resources;

use App\Filament\Ujm\Resources\DokumenProdiResource\Pages;
use App\Models\Dokumen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Auth;

class DokumenProdiResource extends Resource
{
  protected static ?string $model = Dokumen::class;

  protected static ?string $navigationIcon = 'heroicon-o-document-text';

  protected static ?string $navigationLabel = 'Dokumen Mutu';

  protected static ?string $modelLabel = 'Dokumen';

  protected static ?string $pluralModelLabel = 'Dokumen Mutu Program Studi';

  protected static ?int $navigationSort = 2;

  protected static ?string $navigationGroup = 'Dokumen';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make('Informasi Dokumen')
          ->schema([
            Forms\Components\TextInput::make('nama')
              ->required()
              ->maxLength(255),
            Forms\Components\Textarea::make('deskripsi')
              ->rows(3)
              ->maxLength(500),
            Forms\Components\Select::make('kategori')
              ->options([
                'kebijakan_mutu' => 'Kebijakan Mutu Prodi',
                'standar_mutu' => 'Standar Mutu Prodi',
                'prosedur' => 'Prosedur/SOP',
                'instrumen' => 'Instrumen',
                'laporan_ami' => 'Laporan Hasil AMI',
                'laporan_survei' => 'Laporan Survei Kepuasan',
                'evaluasi_diri' => 'Evaluasi Diri (LED)',
                'lkps' => 'LKPS',
                'sertifikat_akreditasi' => 'Sertifikat Akreditasi',
                'kurikulum' => 'Kurikulum',
                'data_pendukung' => 'Data Pendukung',
                'dokumentasi_kegiatan' => 'Dokumentasi Kegiatan',
              ])
              ->required(),
            Forms\Components\Hidden::make('level')
              ->default('prodi'),
            Forms\Components\Hidden::make('program_studi_id')
              ->default(fn() => Auth::user()->programStudi?->id),
            Forms\Components\Hidden::make('user_id')
              ->default(fn() => Auth::user()->id),
          ])->columns(2),

        Forms\Components\Section::make('Upload Dokumen')
          ->schema([
            Forms\Components\Select::make('tipe')
              ->options([
                'file' => 'File Upload',
                'url' => 'URL/Link',
              ])
              ->default('file')
              ->required()
              ->reactive(),
            Forms\Components\FileUpload::make('path')
              ->label('File Dokumen')
              ->directory(fn() => 'dokumen/prodi/' . Auth::user()->programStudi?->kode)
              ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
              ->maxSize(10240)
              ->helperText('Format: PDF, DOC, DOCX. Maksimal 10MB')
              ->visible(fn(Get $get) => $get('tipe') === 'file')
              ->required(fn(Get $get) => $get('tipe') === 'file'),
            Forms\Components\TextInput::make('url')
              ->label('URL Dokumen')
              ->url()
              ->helperText('Masukkan URL lengkap dokumen')
              ->visible(fn(Get $get) => $get('tipe') === 'url')
              ->required(fn(Get $get) => $get('tipe') === 'url'),
          ])->columns(1),

        Forms\Components\Section::make('Klasifikasi')
          ->schema([
            Forms\Components\TextInput::make('kriteria')
              ->helperText('Contoh: Tata Kelola, Pendidikan, Penelitian, Pengabdian'),
            Forms\Components\TextInput::make('sub_kriteria')
              ->label('Sub Kriteria')
              ->helperText('Contoh: Sistem Penjaminan Mutu, Kurikulum, Luaran'),
            Forms\Components\Textarea::make('catatan')
              ->rows(2)
              ->columnSpanFull(),
          ])->columns(2),

        Forms\Components\Section::make('Pengaturan')
          ->schema([
            Forms\Components\Toggle::make('is_visible_to_asesor')
              ->label('Tampilkan ke Asesor')
              ->helperText('Izinkan asesor untuk melihat dokumen ini')
              ->default(false),
            Forms\Components\Toggle::make('is_active')
              ->label('Status Aktif')
              ->default(true),
          ])->columns(2),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('nama')
          ->searchable()
          ->limit(40),
        Tables\Columns\TextColumn::make('kategori')
          ->badge()
          ->formatStateUsing(fn(string $state): string => ucwords(str_replace('_', ' ', $state)))
          ->color(fn(string $state): string => match ($state) {
            'lkps' => 'success',
            'evaluasi_diri' => 'warning',
            'sertifikat_akreditasi' => 'danger',
            'laporan_ami' => 'info',
            default => 'gray',
          }),
        Tables\Columns\TextColumn::make('tipe')
          ->badge()
          ->color(fn(string $state): string => match ($state) {
            'file' => 'success',
            'url' => 'warning',
          }),
        Tables\Columns\TextColumn::make('kriteria')
          ->searchable()
          ->toggleable(),
        Tables\Columns\IconColumn::make('is_visible_to_asesor')
          ->label('Asesor')
          ->boolean()
          ->trueIcon('heroicon-o-eye')
          ->falseIcon('heroicon-o-eye-slash')
          ->trueColor('success')
          ->falseColor('gray'),
        Tables\Columns\IconColumn::make('is_active')
          ->label('Aktif')
          ->boolean(),
        Tables\Columns\TextColumn::make('created_at')
          ->label('Tanggal Upload')
          ->dateTime('d M Y')
          ->sortable(),
      ])
      ->filters([
        Tables\Filters\SelectFilter::make('kategori')
          ->options([
            'lkps' => 'LKPS',
            'evaluasi_diri' => 'Evaluasi Diri (LED)',
            'sertifikat_akreditasi' => 'Sertifikat Akreditasi',
            'laporan_ami' => 'Laporan AMI',
            'laporan_survei' => 'Laporan Survei',
            'kurikulum' => 'Kurikulum',
          ])
          ->multiple(),
        Tables\Filters\TernaryFilter::make('is_visible_to_asesor')
          ->label('Terlihat oleh Asesor'),
      ])
      ->actions([
        Tables\Actions\Action::make('download')
          ->label('Download')
          ->icon('heroicon-o-arrow-down-tray')
          ->color('success')
          ->url(
            fn(Dokumen $record): string =>
            $record->tipe === 'file'
              ? asset('storage/' . $record->path)
              : $record->url
          )
          ->openUrlInNewTab(),
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
          Tables\Actions\BulkAction::make('toggleAsesor')
            ->label('Toggle Visibilitas Asesor')
            ->icon('heroicon-o-eye')
            ->requiresConfirmation()
            ->action(fn($records) => $records->each(function ($record) {
              $record->update([
                'is_visible_to_asesor' => !$record->is_visible_to_asesor
              ]);
            }))
            ->deselectRecordsAfterCompletion(),
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
      'index' => Pages\ListDokumenProdis::route('/'),
      'create' => Pages\CreateDokumenProdi::route('/create'),
      'edit' => Pages\EditDokumenProdi::route('/{record}/edit'),
    ];
  }

  public static function getNavigationBadge(): ?string
  {
    return static::getEloquentQuery()->count();
  }
}