<?php

// Lokasi file: app/Filament/Gjm/Resources/BeritaResource.php

namespace App\Filament\Gjm\Resources;

use App\Filament\Gjm\Resources\BeritaResource\Pages;
use App\Models\Berita;
use App\Models\ProgramStudi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BeritaResource extends Resource
{
  protected static ?string $model = Berita::class;

  protected static ?string $navigationIcon = 'heroicon-o-newspaper';

  protected static ?string $navigationGroup = 'Informasi';

  protected static ?int $navigationSort = 1;

  protected static ?string $navigationLabel = 'Berita & Pengumuman';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make('Informasi Berita')
          ->schema([
            Forms\Components\TextInput::make('judul')
              ->required()
              ->maxLength(255)
              ->live(onBlur: true)
              ->afterStateUpdated(
                fn(string $state, Forms\Set $set) =>
                $set('slug', Str::slug($state))
              ),

            Forms\Components\TextInput::make('slug')
              ->required()
              ->maxLength(255)
              ->unique(ignoreRecord: true)
              ->readOnly(),

            Forms\Components\Select::make('kategori')
              ->options([
                'berita' => 'Berita',
                'pengumuman' => 'Pengumuman',
              ])
              ->required()
              ->native(false),

            Forms\Components\Select::make('level')
              ->label('Target Level')
              ->options([
                'fakultas' => 'Fakultas',
                'prodi' => 'Program Studi',
              ])
              ->required()
              ->reactive()
              ->afterStateUpdated(fn(Forms\Set $set) => $set('program_studi_id', null))
              ->default('fakultas'),

            Forms\Components\Select::make('program_studi_id')
              ->label('Program Studi')
              ->options(function () {
                return ProgramStudi::where('fakultas_id', Auth::user()->fakultas_id)
                  ->where('is_active', true)
                  ->pluck('nama', 'id');
              })
              ->required(fn(Forms\Get $get): bool => $get('level') === 'prodi')
              ->visible(fn(Forms\Get $get): bool => $get('level') === 'prodi')
              ->helperText('Pilih program studi jika berita untuk level prodi')
              ->searchable(),
          ])
          ->columns(2),

        Forms\Components\Section::make('Konten')
          ->schema([
            Forms\Components\RichEditor::make('konten')
              ->required()
              ->columnSpanFull()
              ->toolbarButtons([
                'attachFiles',
                'blockquote',
                'bold',
                'bulletList',
                'codeBlock',
                'h2',
                'h3',
                'italic',
                'link',
                'orderedList',
                'redo',
                'strike',
                'table',
                'undo',
              ]),

            SpatieMediaLibraryFileUpload::make('gambar')
              ->label('Gambar/Foto')
              ->image()
              ->maxSize(2048)
              ->imageEditor()
              ->imageEditorAspectRatios([
                '16:9',
                '4:3',
                '1:1',
              ])
              ->columnSpanFull()
              ->helperText('Upload gambar/foto berita (max 2MB)'),
          ]),

        Forms\Components\Section::make('Status Publikasi')
          ->schema([
            Forms\Components\Toggle::make('is_published')
              ->label('Publikasikan')
              ->helperText('Aktifkan untuk mempublikasikan berita')
              ->reactive(),

            Forms\Components\DateTimePicker::make('published_at')
              ->label('Tanggal Publikasi')
              ->visible(fn(Forms\Get $get): bool => $get('is_published') === true)
              ->required(fn(Forms\Get $get): bool => $get('is_published') === true)
              ->default(now())
              ->native(false),
          ])
          ->columns(2),

        Forms\Components\Hidden::make('user_id')
          ->default(Auth::id()),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('judul')
          ->searchable()
          ->limit(50)
          ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
            $state = $column->getState();
            return strlen($state) > 50 ? $state : null;
          }),

        Tables\Columns\BadgeColumn::make('kategori')
          ->colors([
            'primary' => 'berita',
            'warning' => 'pengumuman',
          ]),

        Tables\Columns\BadgeColumn::make('level')
          ->colors([
            'success' => 'fakultas',
            'info' => 'prodi',
          ]),

        Tables\Columns\TextColumn::make('programStudi.nama')
          ->label('Program Studi')
          ->placeholder('Semua Prodi')
          ->toggleable(),

        Tables\Columns\IconColumn::make('is_published')
          ->label('Status')
          ->boolean()
          ->trueIcon('heroicon-o-check-circle')
          ->falseIcon('heroicon-o-x-circle')
          ->trueColor('success')
          ->falseColor('danger'),

        Tables\Columns\TextColumn::make('published_at')
          ->label('Tgl Publikasi')
          ->dateTime('d M Y H:i')
          ->sortable()
          ->toggleable(),

        Tables\Columns\TextColumn::make('user.name')
          ->label('Penulis')
          ->toggleable(),

        Tables\Columns\TextColumn::make('created_at')
          ->label('Dibuat')
          ->dateTime('d M Y')
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->filters([
        Tables\Filters\SelectFilter::make('kategori')
          ->options([
            'berita' => 'Berita',
            'pengumuman' => 'Pengumuman',
          ]),

        Tables\Filters\SelectFilter::make('level')
          ->options([
            'fakultas' => 'Fakultas',
            'prodi' => 'Program Studi',
          ]),

        Tables\Filters\SelectFilter::make('program_studi_id')
          ->label('Program Studi')
          ->options(function () {
            return ProgramStudi::where('fakultas_id', Auth::user()->fakultas_id)
              ->pluck('nama', 'id');
          })
          ->searchable(),

        Tables\Filters\TernaryFilter::make('is_published')
          ->label('Status Publikasi')
          ->boolean()
          ->trueLabel('Terpublikasi')
          ->falseLabel('Draft')
          ->placeholder('Semua'),
      ])
      ->actions([
        Tables\Actions\ViewAction::make(),
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make()
          ->requiresConfirmation(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
          Tables\Actions\BulkAction::make('publish')
            ->label('Publikasikan')
            ->icon('heroicon-o-check')
            ->color('success')
            ->action(fn($records) => $records->each->update([
              'is_published' => true,
              'published_at' => now(),
            ]))
            ->requiresConfirmation()
            ->deselectRecordsAfterCompletion(),
          Tables\Actions\BulkAction::make('unpublish')
            ->label('Batalkan Publikasi')
            ->icon('heroicon-o-x-mark')
            ->color('danger')
            ->action(fn($records) => $records->each->update([
              'is_published' => false,
            ]))
            ->requiresConfirmation()
            ->deselectRecordsAfterCompletion(),
        ]),
      ])
      ->defaultSort('created_at', 'desc');
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
      'index' => Pages\ListBeritas::route('/'),
      'create' => Pages\CreateBerita::route('/create'),
      'edit' => Pages\EditBerita::route('/{record}/edit'),
    ];
  }

  public static function getEloquentQuery(): Builder
  {
    $fakultasId = Auth::user()->fakultas_id;

    return parent::getEloquentQuery()
      ->where(function ($query) use ($fakultasId) {
        // Berita level fakultas
        $query->where('level', 'fakultas')
          ->whereNull('program_studi_id')
          // Atau berita dari prodi dalam fakultas ini
          ->orWhereHas('programStudi', function ($q) use ($fakultasId) {
            $q->where('fakultas_id', $fakultasId);
          });
      });
  }

  public static function getNavigationBadge(): ?string
  {
    $fakultasId = Auth::user()->fakultas_id;

    return static::getModel()::where(function ($query) use ($fakultasId) {
      $query->where('level', 'fakultas')
        ->whereNull('program_studi_id')
        ->orWhereHas('programStudi', function ($q) use ($fakultasId) {
          $q->where('fakultas_id', $fakultasId);
        });
    })
      ->where('is_published', false)
      ->count();
  }

  public static function getNavigationBadgeColor(): ?string
  {
    return static::getNavigationBadge() > 0 ? 'warning' : null;
  }
}