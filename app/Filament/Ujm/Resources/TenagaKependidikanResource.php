<?php

// 1. app/Filament/Ujm/Resources/TenagaKependidikanResource.php
namespace App\Filament\Ujm\Resources;

use App\Filament\Ujm\Resources\TenagaKependidikanResource\Pages;
use App\Models\TenagaKependidikan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TenagaKependidikanResource extends Resource
{
  protected static ?string $model = TenagaKependidikan::class;

  protected static ?string $navigationIcon = 'heroicon-o-briefcase';

  protected static ?string $navigationLabel = 'Tenaga Kependidikan';

  protected static ?string $modelLabel = 'Tenaga Kependidikan';

  protected static ?string $pluralModelLabel = 'Data Tenaga Kependidikan';

  protected static ?int $navigationSort = 2;

  protected static ?string $navigationGroup = 'Data Pendukung';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make('Identitas Pegawai')
          ->schema([
            Forms\Components\TextInput::make('nama')
              ->required()
              ->maxLength(255),
            Forms\Components\TextInput::make('nip')
              ->label('NIP')
              ->required()
              ->unique(ignoreRecord: true)
              ->maxLength(18)
              ->placeholder('18 digit NIP')
              ->helperText('Nomor Induk Pegawai'),
            Forms\Components\Select::make('jenis_kelamin')
              ->options([
                'L' => 'Laki-laki',
                'P' => 'Perempuan',
              ])
              ->required(),
          ])->columns(3),

        Forms\Components\Section::make('Informasi Kepegawaian')
          ->schema([
            Forms\Components\Select::make('jabatan')
              ->options([
                'Kepala Tata Usaha' => 'Kepala Tata Usaha',
                'Staf Administrasi' => 'Staf Administrasi',
                'Staf Akademik' => 'Staf Akademik',
                'Staf Keuangan' => 'Staf Keuangan',
                'Staf Umum' => 'Staf Umum',
                'Laboran' => 'Laboran',
                'Teknisi' => 'Teknisi',
                'Pustakawan' => 'Pustakawan',
                'Pranata Komputer' => 'Pranata Komputer',
                'Arsiparis' => 'Arsiparis',
              ])
              ->required()
              ->searchable(),
            Forms\Components\TextInput::make('unit_kerja')
              ->default(fn() => 'Program Studi ' . Auth::user()->programStudi?->nama)
              ->maxLength(255),
            Forms\Components\Select::make('status_kepegawaian')
              ->options([
                'PNS' => 'PNS',
                'PPPK' => 'PPPK',
                'Honorer' => 'Honorer',
                'Kontrak' => 'Kontrak',
                'Tetap Non-ASN' => 'Tetap Non-ASN',
              ])
              ->required(),
            Forms\Components\Select::make('pendidikan_terakhir')
              ->options([
                'SD' => 'SD',
                'SMP' => 'SMP',
                'SMA/SMK' => 'SMA/SMK',
                'D1' => 'D1',
                'D2' => 'D2',
                'D3' => 'D3',
                'D4' => 'D4',
                'S1' => 'S1',
                'S2' => 'S2',
                'S3' => 'S3',
              ])
              ->required(),
          ])->columns(2),

        Forms\Components\Section::make('Kontak & Status')
          ->schema([
            Forms\Components\TextInput::make('email')
              ->email()
              ->maxLength(255),
            Forms\Components\TextInput::make('telepon')
              ->tel()
              ->maxLength(20)
              ->placeholder('Contoh: 081234567890'),
            Forms\Components\DatePicker::make('tanggal_masuk')
              ->native(false)
              ->maxDate(now()),
            Forms\Components\Toggle::make('is_active')
              ->label('Status Aktif')
              ->default(true)
              ->helperText('Pegawai aktif akan ditampilkan dalam laporan'),
            Forms\Components\Hidden::make('program_studi_id')
              ->default(fn() => Auth::user()->programStudi?->id),
          ])->columns(4),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('nama')
          ->searchable()
          ->sortable(),
        Tables\Columns\TextColumn::make('nip')
          ->label('NIP')
          ->searchable()
          ->copyable()
          ->copyMessage('NIP disalin!'),
        Tables\Columns\TextColumn::make('jabatan')
          ->badge()
          ->color(fn(string $state): string => match ($state) {
            'Kepala Tata Usaha' => 'danger',
            'Laboran' => 'warning',
            'Teknisi' => 'info',
            'Pranata Komputer' => 'success',
            default => 'gray',
          }),
        Tables\Columns\TextColumn::make('status_kepegawaian')
          ->label('Status')
          ->badge()
          ->color(fn(string $state): string => match ($state) {
            'PNS' => 'success',
            'PPPK' => 'info',
            'Tetap Non-ASN' => 'warning',
            'Kontrak' => 'gray',
            'Honorer' => 'gray',
          }),
        Tables\Columns\TextColumn::make('pendidikan_terakhir')
          ->label('Pendidikan')
          ->toggleable(),
        Tables\Columns\TextColumn::make('unit_kerja')
          ->label('Unit')
          ->toggleable()
          ->limit(30),
        Tables\Columns\TextColumn::make('masa_kerja')
          ->label('Masa Kerja')
          ->getStateUsing(function ($record) {
            if (!$record->tanggal_masuk) return '-';
            $years = $record->tanggal_masuk->diffInYears(now());
            $months = $record->tanggal_masuk->diffInMonths(now()) % 12;
            return "{$years} tahun {$months} bulan";
          })
          ->toggleable(),
        Tables\Columns\IconColumn::make('is_active')
          ->label('Aktif')
          ->boolean(),
      ])
      ->filters([
        Tables\Filters\SelectFilter::make('jabatan')
          ->options([
            'Kepala Tata Usaha' => 'Kepala Tata Usaha',
            'Staf Administrasi' => 'Staf Administrasi',
            'Staf Akademik' => 'Staf Akademik',
            'Laboran' => 'Laboran',
            'Teknisi' => 'Teknisi',
          ])
          ->multiple(),
        Tables\Filters\SelectFilter::make('status_kepegawaian')
          ->options([
            'PNS' => 'PNS',
            'PPPK' => 'PPPK',
            'Honorer' => 'Honorer',
            'Kontrak' => 'Kontrak',
            'Tetap Non-ASN' => 'Tetap Non-ASN',
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
        ]),
      ])
      ->defaultSort('nama', 'asc');
  }

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()
      ->where('program_studi_id', Auth::user()?->programStudi?->id);
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
      'index' => Pages\ListTenagaKependidikans::route('/'),
      'create' => Pages\CreateTenagaKependidikan::route('/create'),
      'edit' => Pages\EditTenagaKependidikan::route('/{record}/edit'),
    ];
  }

  public static function getNavigationBadge(): ?string
  {
    return static::getEloquentQuery()
      ->where('is_active', true)
      ->count();
  }
}