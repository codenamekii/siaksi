<?php

namespace App\Filament\Ujm\Resources;

use App\Filament\Ujm\Resources\GaleriKegiatanResource\Pages;
use App\Models\GaleriKegiatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class GaleriKegiatanResource extends Resource
{
    protected static ?string $model = GaleriKegiatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';

    protected static ?string $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Dokumentasi Kegiatan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Kegiatan')
                ->schema([
                    Forms\Components\TextInput::make('judul')->label('Judul Kegiatan')->required()->maxLength(255),

                    Forms\Components\Textarea::make('deskripsi')->label('Deskripsi')->rows(3)->required(),

                    Forms\Components\DatePicker::make('tanggal_kegiatan')->label('Tanggal Kegiatan')->required()->native(false)->default(now()),

                    Forms\Components\Select::make('kategori')
                        ->label('Kategori')
                        ->options([
                            'kegiatan' => 'Kegiatan',
                            'prestasi' => 'Prestasi',
                            'fasilitas' => 'Fasilitas',
                            'lainnya' => 'Lainnya',
                        ])
                        ->default('kegiatan')
                        ->required(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Dokumentasi')->schema([
                Forms\Components\FileUpload::make('gambar')
                    ->label('Foto Dokumentasi')
                    ->multiple()
                    ->image()
                    ->directory('galeri/prodi/' . (Auth::user()->program_studi_id ?? 'default'))
                    ->maxSize(5120) // 5MB per file
                    ->maxFiles(10)
                    ->reorderable()
                    ->imageResizeMode('contain')
                    ->imageResizeTargetWidth('1920')
                    ->imageResizeTargetHeight('1080')
                    ->required()
                    ->helperText('Upload foto dokumentasi kegiatan (maksimal 10 foto, masing-masing 5MB)'),
            ]),

            Forms\Components\Section::make('Pengaturan')->schema([Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true)->helperText('Nonaktifkan untuk menyembunyikan dari galeri publik'), Forms\Components\Hidden::make('program_studi_id')->default(fn() => Auth::user()->program_studi_id)]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')->label('Foto')->circular()->stacked()->limit(3)->limitedRemainingText(),

                Tables\Columns\TextColumn::make('judul')->label('Judul Kegiatan')->searchable()->sortable()->limit(50),

                Tables\Columns\BadgeColumn::make('kategori')
                    ->label('Kategori')
                    ->colors([
                        'primary' => 'kegiatan',
                        'success' => 'prestasi',
                        'warning' => 'fasilitas',
                        'gray' => 'lainnya',
                    ]),

                Tables\Columns\TextColumn::make('tanggal_kegiatan')->label('Tanggal')->date('d M Y')->sortable(),

                Tables\Columns\TextColumn::make('deskripsi')->label('Deskripsi')->limit(50)->toggleable(),

                Tables\Columns\IconColumn::make('is_active')->label('Status')->boolean(),

                Tables\Columns\TextColumn::make('created_at')->label('Diupload')->dateTime('d M Y')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'kegiatan' => 'Kegiatan',
                        'prestasi' => 'Prestasi',
                        'fasilitas' => 'Fasilitas',
                        'lainnya' => 'Lainnya',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')->label('Status Aktif'),
            ])
            ->actions([Tables\Actions\ViewAction::make(), Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
            ->defaultSort('tanggal_kegiatan', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('program_studi_id', Auth::user()->program_studi_id);
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

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->where('is_active', true)->count();
    }
}
