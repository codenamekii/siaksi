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

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Profil';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Upload Struktur Organisasi')
                ->schema([
                    Forms\Components\TextInput::make('nama') // Changed from 'judul' to 'nama'
                        ->label('Nama/Judul')
                        ->required()
                        ->maxLength(255)
                        ->default('Struktur Organisasi Program Studi'),

                    Forms\Components\Textarea::make('deskripsi')->rows(3)->maxLength(500)->helperText('Deskripsi singkat tentang struktur organisasi'),

                    Forms\Components\FileUpload::make('file_path') // Changed from 'gambar' to 'file_path'
                        ->label('File Struktur Organisasi')
                        ->required()
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'])
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
                        ->helperText('Upload gambar struktur organisasi atau PDF. Format: JPG, PNG, PDF. Maksimal 5MB')
                        ->columnSpanFull()
                        ->reactive()
                        ->afterStateUpdated(function ($state, Forms\Set $set) {
                            if ($state) {
                                $extension = pathinfo($state, PATHINFO_EXTENSION);
                                $set('tipe', in_array(strtolower($extension), ['pdf']) ? 'pdf' : 'image');
                            }
                        }),

                    Forms\Components\Hidden::make('tipe')->default('image'),

                    Forms\Components\Toggle::make('is_active')->label('Status Aktif')->default(true)->helperText('Hanya struktur organisasi aktif yang akan ditampilkan'),

                    Forms\Components\Hidden::make('level')->default('prodi'),

                    Forms\Components\Hidden::make('program_studi_id')->default(fn() => Auth::user()->programStudi?->id),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tipe')
                    ->label('Tipe')
                    ->badge()
                    ->color(
                        fn(?string $state): string => match ($state) {
                            'image' => 'success',
                            'pdf' => 'warning',
                            default => 'gray',
                        },
                    )
                    ->default('image'),

                Tables\Columns\ImageColumn::make('file_path') // Changed from 'gambar'
                    ->label('Preview')
                    ->width(150)
                    ->height(100)
                    ->disk('public')
                    ->visibility('public')
                    ->visible(fn($record) => $record && $record->tipe === 'image')
                    ->extraImgAttributes(['loading' => 'lazy']),

                Tables\Columns\TextColumn::make('nama') // Changed from 'judul'
                    ->label('Nama/Judul')
                    ->searchable(),

                Tables\Columns\TextColumn::make('deskripsi')->limit(50)->toggleable(),

                Tables\Columns\IconColumn::make('is_active')->label('Status')->boolean()->trueIcon('heroicon-o-check-circle')->falseIcon('heroicon-o-x-circle')->trueColor('success')->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Upload')->dateTime('d M Y')->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Status Aktif'),

                Tables\Filters\SelectFilter::make('tipe')->options([
                    'image' => 'Gambar',
                    'pdf' => 'PDF',
                ]),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading(fn($record) => $record->nama)
                    ->modalContent(function ($record) {
                        if (!$record) {
                            return new \Illuminate\Support\HtmlString('<p>Data tidak ditemukan</p>');
                        }

                        if ($record->tipe === 'pdf') {
                            $pdfUrl = asset('storage/' . $record->file_path);
                            return new \Illuminate\Support\HtmlString(
                                '
                    <div class="p-4">
                        <div class="text-center space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                ' .
                                    e($record->nama) .
                                    '
                            </h3>
                            ' .
                                    ($record->deskripsi
                                        ? '
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                ' .
                                            e($record->deskripsi) .
                                            '
                            </p>'
                                        : '') .
                                    '
                            <div class="mt-4">
                                <a href="' .
                                    $pdfUrl .
                                    '" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Buka PDF
                                </a>
                            </div>
                        </div>
                    </div>
                ',
                            );
                        }

                        $imageUrl = asset('storage/' . $record->file_path);

                        return new \Illuminate\Support\HtmlString(
                            '
                <div class="p-4">
                    <div class="text-center space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            ' .
                                e($record->nama) .
                                '
                        </h3>
                        ' .
                                ($record->deskripsi
                                    ? '
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            ' .
                                        e($record->deskripsi) .
                                        '
                        </p>'
                                    : '') .
                                '
                        <div class="flex justify-center">
                            <img
                                src="' .
                                $imageUrl .
                                '"
                                alt="' .
                                e($record->nama) .
                                '"
                                class="max-w-full h-auto rounded-lg shadow-lg"
                                style="max-height: 70vh;"
                                onerror="this.onerror=null; this.src=\'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjZGRkIi8+CiAgICA8dGV4dCB4PSI1MCUiIHk9IjUwJSIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjE4IiBmaWxsPSIjOTk5IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5JbWFnZSBOb3QgRm91bmQ8L3RleHQ+Cjwvc3ZnPg==\';"
                            >
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            Diupload pada: ' .
                                $record->created_at->format('d F Y') .
                                '
                        </div>
                    </div>
                </div>
            ',
                        );
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalWidth(MaxWidth::SevenExtraLarge),

                Tables\Actions\EditAction::make()->beforeFormFilled(function ($data, $record) {
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
                        if ($record->file_path && Storage::disk('public')->exists($record->file_path)) {
                            Storage::disk('public')->delete($record->file_path);
                        }
                    }),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
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
        return static::getModel()
            ::where('level', 'prodi')
            ->where('program_studi_id', Auth::user()->programStudi?->id)
            ->where('is_active', true)
            ->count();
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Organisasi';
    }
}
