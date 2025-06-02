<?php

// 1. app/Filament/Ujm/Resources/LaporanResource.php
namespace App\Filament\Ujm\Resources;

use App\Filament\Ujm\Resources\LaporanResource\Pages;
use App\Models\Dokumen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Auth;

class LaporanResource extends Resource
{
  protected static ?string $model = Dokumen::class;

  protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

  protected static ?string $navigationLabel = 'Laporan & Evaluasi';

  protected static ?string $modelLabel = 'Laporan';

  protected static ?string $pluralModelLabel = 'Hasil Evaluasi & Peningkatan Mutu';

  protected static ?int $navigationSort = 3;

  protected static ?string $navigationGroup = 'Evaluasi & Peningkatan';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make('Informasi Laporan')
          ->schema([
            Forms\Components\TextInput::make('nama')
              ->label('Judul Laporan')
              ->required()
              ->maxLength(255)
              ->placeholder('Contoh: Laporan Hasil AMI Semester Ganjil 2024'),
            Forms\Components\Select::make('kategori')
              ->label('Jenis Laporan')
              ->options([
                'laporan_ami' => 'Laporan Hasil AMI',
                'laporan_survei' => 'Laporan Survei Kepuasan',
                'analisis_capaian' => 'Analisis Data Capaian',
                'rencana_tindak_lanjut' => 'Rencana Tindak Lanjut (RTL)',
                'laporan_kinerja' => 'Laporan Kinerja',
              ])
              ->required()
              ->reactive(),
            Forms\Components\Select::make('periode')
              ->label('Periode Laporan')
              ->options([
                'semester_ganjil' => 'Semester Ganjil',
                'semester_genap' => 'Semester Genap',
                'tahunan' => 'Tahunan',
                'triwulan_1' => 'Triwulan I',
                'triwulan_2' => 'Triwulan II',
                'triwulan_3' => 'Triwulan III',
                'triwulan_4' => 'Triwulan IV',
              ])
              ->required(),
            Forms\Components\Select::make('tahun')
              ->options(array_combine(
                range(date('Y'), date('Y') - 5),
                range(date('Y'), date('Y') - 5)
              ))
              ->required()
              ->default(date('Y')),
          ])->columns(2),

        Forms\Components\Section::make('Detail Laporan')
          ->schema([
            Forms\Components\Textarea::make('deskripsi')
              ->label('Ringkasan Eksekutif')
              ->rows(4)
              ->maxLength(1000)
              ->helperText('Ringkasan singkat isi laporan'),
            Forms\Components\Select::make('sub_kategori')
              ->label('Detail Jenis')
              ->options(function (Get $get) {
                return match ($get('kategori')) {
                  'laporan_survei' => [
                    'survei_mahasiswa' => 'Survei Kepuasan Mahasiswa',
                    'survei_dosen' => 'Survei Kepuasan Dosen',
                    'survei_alumni' => 'Survei Kepuasan Alumni',
                    'survei_pengguna' => 'Survei Pengguna Lulusan',
                    'survei_mitra' => 'Survei Kepuasan Mitra',
                  ],
                  'analisis_capaian' => [
                    'capaian_pembelajaran' => 'Capaian Pembelajaran',
                    'capaian_kinerja' => 'Capaian Kinerja Dosen',
                    'capaian_penelitian' => 'Capaian Penelitian',
                    'capaian_pengabdian' => 'Capaian Pengabdian',
                  ],
                  default => []
                };
              })
              ->visible(fn(Get $get) => in_array($get('kategori'), ['laporan_survei', 'analisis_capaian']))
              ->required(fn(Get $get) => in_array($get('kategori'), ['laporan_survei', 'analisis_capaian'])),
          ])->columns(1),

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
              ->label('File Laporan')
              ->directory(fn(Get $get) => 'laporan/' . Auth::user()->programStudi?->kode . '/' . $get('kategori'))
              ->acceptedFileTypes(['application/pdf', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
              ->maxSize(20480)
              ->helperText('Format: PDF atau Excel. Maksimal 20MB')
              ->downloadable()
              ->openable()
              ->visible(fn(Get $get) => $get('tipe') === 'file')
              ->required(fn(Get $get) => $get('tipe') === 'file'),
            Forms\Components\TextInput::make('url')
              ->label('URL Laporan')
              ->url()
              ->helperText('Link Google Drive, OneDrive, atau cloud storage lainnya')
              ->visible(fn(Get $get) => $get('tipe') === 'url')
              ->required(fn(Get $get) => $get('tipe') === 'url'),
          ])->columns(1),

        Forms\Components\Section::make('Temuan & Tindak Lanjut')
          ->schema([
            Forms\Components\Repeater::make('temuan')
              ->label('Temuan Utama')
              ->schema([
                Forms\Components\TextInput::make('temuan')
                  ->label('Temuan')
                  ->required(),
                Forms\Components\Select::make('kategori_temuan')
                  ->label('Kategori')
                  ->options([
                    'kelebihan' => 'Kelebihan',
                    'kekurangan' => 'Kekurangan',
                    'peluang' => 'Peluang',
                    'ancaman' => 'Ancaman',
                  ])
                  ->required(),
              ])
              ->columns(2)
              ->collapsible()
              ->defaultItems(0)
              ->visible(fn(Get $get) => in_array($get('kategori'), ['laporan_ami', 'analisis_capaian'])),
            Forms\Components\Textarea::make('catatan')
              ->label('Rekomendasi & Tindak Lanjut')
              ->rows(3)
              ->maxLength(1000),
          ]),

        Forms\Components\Section::make('Pengaturan')
          ->schema([
            Forms\Components\Toggle::make('is_visible_to_asesor')
              ->label('Tampilkan ke Asesor')
              ->helperText('Izinkan asesor untuk melihat laporan ini')
              ->default(true),
            Forms\Components\Toggle::make('is_active')
              ->label('Status Aktif')
              ->default(true),
            Forms\Components\Hidden::make('level')
              ->default('prodi'),
            Forms\Components\Hidden::make('program_studi_id')
              ->default(fn() => Auth::user()->programStudi?->id),
            Forms\Components\Hidden::make('user_id')
              ->default(fn() => Auth::id()),
          ])->columns(2),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('nama')
          ->label('Judul Laporan')
          ->searchable()
          ->limit(40),
        Tables\Columns\TextColumn::make('kategori')
          ->label('Jenis')
          ->badge()
          ->formatStateUsing(fn(string $state): string => match ($state) {
            'laporan_ami' => 'Laporan AMI',
            'laporan_survei' => 'Survei Kepuasan',
            'analisis_capaian' => 'Analisis Capaian',
            'rencana_tindak_lanjut' => 'RTL',
            'laporan_kinerja' => 'Laporan Kinerja',
            default => ucwords(str_replace('_', ' ', $state))
          })
          ->color(fn(string $state): string => match ($state) {
            'laporan_ami' => 'danger',
            'laporan_survei' => 'warning',
            'analisis_capaian' => 'info',
            'rencana_tindak_lanjut' => 'success',
            default => 'gray',
          }),
        Tables\Columns\TextColumn::make('periode_tahun')
          ->label('Periode')
          ->getStateUsing(
            fn($record) =>
            ucwords(str_replace('_', ' ', $record->periode ?? '')) . ' ' . ($record->tahun ?? date('Y'))
          ),
        Tables\Columns\TextColumn::make('sub_kategori')
          ->label('Detail')
          ->formatStateUsing(fn($state) => $state ? ucwords(str_replace('_', ' ', $state)) : '-')
          ->toggleable(),
        Tables\Columns\TextColumn::make('tipe')
          ->badge()
          ->color(fn(string $state): string => match ($state) {
            'file' => 'success',
            'url' => 'warning',
          }),
        Tables\Columns\IconColumn::make('is_visible_to_asesor')
          ->label('Asesor')
          ->boolean()
          ->trueIcon('heroicon-o-eye')
          ->falseIcon('heroicon-o-eye-slash'),
        Tables\Columns\TextColumn::make('created_at')
          ->label('Tanggal Upload')
          ->dateTime('d M Y')
          ->sortable(),
      ])
      ->filters([
        Tables\Filters\SelectFilter::make('kategori')
          ->label('Jenis Laporan')
          ->options([
            'laporan_ami' => 'Laporan AMI',
            'laporan_survei' => 'Survei Kepuasan',
            'analisis_capaian' => 'Analisis Capaian',
            'rencana_tindak_lanjut' => 'RTL',
          ]),
        Tables\Filters\SelectFilter::make('tahun')
          ->options(array_combine(
            range(date('Y'), date('Y') - 5),
            range(date('Y'), date('Y') - 5)
          )),
        Tables\Filters\TernaryFilter::make('is_visible_to_asesor')
          ->label('Terlihat Asesor'),
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
        ]),
      ])
      ->defaultSort('created_at', 'desc');
  }

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()
      ->where('level', 'prodi')
      ->where('program_studi_id', Auth::user()->programStudi?->id)
      ->whereIn('kategori', [
        'laporan_ami',
        'laporan_survei',
        'analisis_capaian',
        'rencana_tindak_lanjut',
        'laporan_kinerja'
      ]);
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
      'index' => Pages\ListLaporans::route('/'),
      'create' => Pages\CreateLaporan::route('/create'),
      'edit' => Pages\EditLaporan::route('/{record}/edit'),
    ];
  }
}