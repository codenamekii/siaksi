<?php

// Lokasi file: app/Filament/Ujm/Resources/StrukturOrganisasiResource.php
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
use Illuminate\Support\Facades\Storage;
use Filament\Support\Enums\MaxWidth;

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
              ->disk('public')
              ->directory('struktur/prodi/' . (Auth::user()->programStudi?->kode ?? 'default'))
              ->visibility('public')
              ->maxSize(5120)
              ->imageResizeMode('contain')
              ->imageResizeTargetWidth('1920')
              ->imageResizeTargetHeight('1080')
              ->imagePreviewHeight('250')
              ->loadingIndicatorPosition('left')
              ->panelAspectRatio('2:1')
              ->panelLayout('integrated')
              ->removeUploadedFileButtonPosition('right')
              ->uploadButtonPosition('left')
              ->uploadProgressIndicatorPosition('left')
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
          ->height(100)
          ->disk('public')
          ->visibility('public')
          ->getStateUsing(function ($record) {
            // Debug: Check if file exists
            if (!$record->gambar) {
              return null;
            }

            // Return the path as stored in database
            return $record->gambar;
          })
          ->extraImgAttributes(['loading' => 'lazy']),
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
          ->color('info')
          ->modalHeading(fn($record) => $record->judul)
          ->modalContent(function ($record) {
            $imageUrl = '';

            // Generate proper image URL
            if ($record->gambar) {
              if (Storage::disk('public')->exists($record->gambar)) {
                $imageUrl = asset('storage/' . $record->gambar);
              } else {
                $imageUrl = asset('storage/' . $record->gambar);
              }
            }

            // Debug info
            $debugInfo = '';
            if (config('app.debug')) {
              $debugInfo = '
                                <div class="mt-4 p-2 bg-gray-100 dark:bg-gray-800 rounded text-xs">
                                    <p>Path in DB: ' . e($record->gambar) . '</p>
                                    <p>Image URL: ' . e($imageUrl) . '</p>
                                    <p>File exists: ' . (Storage::disk('public')->exists($record->gambar) ? 'Yes' : 'No') . '</p>
                                </div>
                            ';
            }

            return new \Illuminate\Support\HtmlString('
                            <div class="p-4">
                                <div class="text-center space-y-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        ' . e($record->judul) . '
                                    </h3>
                                    ' . ($record->deskripsi ? '
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        ' . e($record->deskripsi) . '
                                    </p>' : '') . '
                                    <div class="flex justify-center">
                                        <img 
                                            src="' . $imageUrl . '" 
                                            alt="' . e($record->judul) . '"
                                            class="max-w-full h-auto rounded-lg shadow-lg"
                                            style="max-height: 70vh;"
                                            onerror="this.onerror=null; this.src=\'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjZGRkIi8+CiAgICA8dGV4dCB4PSI1MCUiIHk9IjUwJSIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjE4IiBmaWxsPSIjOTk5IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5JbWFnZSBOb3QgRm91bmQ8L3RleHQ+Cjwvc3ZnPg==\';"
                                        >
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        Diupload pada: ' . $record->created_at->format('d F Y') . '
                                    </div>
                                    ' . $debugInfo . '
                                </div>
                            </div>
                        ');
          })
          ->modalSubmitAction(false)
          ->modalCancelActionLabel('Tutup')
          ->modalWidth(MaxWidth::SevenExtraLarge),
        Tables\Actions\EditAction::make()
          ->beforeFormFilled(function ($data, $record) {
            // Ensure is_active is set when other structures exist
            if ($record->is_active) {
              StrukturOrganisasi::where('program_studi_id', $record->program_studi_id)
                ->where('id', '!=', $record->id)
                ->update(['is_active' => false]);
            }
            return $data;
          }),
        Tables\Actions\DeleteAction::make()
          ->requiresConfirmation()
          ->before(function ($record) {
            // Delete file when deleting record
            if ($record->gambar && Storage::disk('public')->exists($record->gambar)) {
              Storage::disk('public')->delete($record->gambar);
            }
          }),
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

  public static function getNavigationBadge(): ?string
  {
    return static::getModel()::where('level', 'prodi')
      ->where('program_studi_id', Auth::user()->programStudi?->id)
      ->where('is_active', true)
      ->count();
  }
}