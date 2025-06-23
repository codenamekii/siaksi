<?php
// Lokasi file: app/Filament/Gjm/Resources/StrukturOrganisasiFakultasResource.php

namespace App\Filament\Gjm\Resources;

use App\Filament\Gjm\Resources\StrukturOrganisasiFakultasResource\Pages;
use App\Models\StrukturOrganisasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class StrukturOrganisasiFakultasResource extends Resource
{
    protected static ?string $model = StrukturOrganisasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Struktur Organisasi';

    protected static ?string $modelLabel = 'Struktur Organisasi';

    protected static ?string $pluralModelLabel = 'Struktur Organisasi';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Profil';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Upload Struktur Organisasi')
                ->description('Upload gambar struktur organisasi fakultas dalam format JPG, PNG atau PDF')
                ->schema([
                    Forms\Components\TextInput::make('nama') // Changed back to 'nama'
                        ->label('Judul/Nama')
                        ->required()
                        ->maxLength(255)
                        ->default('Struktur Organisasi Fakultas'),

                    Forms\Components\Textarea::make('deskripsi')->label('Deskripsi')->rows(3)->maxLength(500)->helperText('Jelaskan periode atau informasi tambahan'),

                    Forms\Components\Select::make('tipe')
                        ->label('Tipe Upload')
                        ->options([
                            'image' => 'Gambar (JPG/PNG)',
                            'pdf' => 'Dokumen PDF',
                        ])
                        ->required()
                        ->reactive()
                        ->default('image'),

                    Forms\Components\FileUpload::make('file_path') // This is correct for form
                        ->label('File Struktur Organisasi')
                        ->directory('struktur-organisasi/fakultas')
                        ->image()
                        ->imageEditor()
                        ->imageEditorAspectRatios([null, '16:9', '4:3', '1:1'])
                        ->maxSize(5120) // 5MB
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->helperText('Format: JPG, PNG, WebP. Maksimal 5MB')
                        ->visible(fn(Forms\Get $get) => $get('tipe') === 'image')
                        ->required(fn(Forms\Get $get) => $get('tipe') === 'image'),

                    Forms\Components\FileUpload::make('file_path') // This is correct for form
                        ->label('File PDF')
                        ->directory('struktur-organisasi/fakultas')
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(10240) // 10MB
                        ->helperText('Format: PDF. Maksimal 10MB')
                        ->visible(fn(Forms\Get $get) => $get('tipe') === 'pdf')
                        ->required(fn(Forms\Get $get) => $get('tipe') === 'pdf'),

                    Forms\Components\Toggle::make('is_active')->label('Status Aktif')->default(true)->helperText('Nonaktifkan jika struktur sudah tidak berlaku'),

                    Forms\Components\Hidden::make('level')->default('fakultas'),

                    Forms\Components\Hidden::make('fakultas_id')->default(fn() => Auth::user()->fakultas_id ?? 1),
                ])
                ->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Judul')->searchable()->sortable(),

                Tables\Columns\TextColumn::make('tipe')->badge()->color(
                    fn(string $state): string => match ($state) {
                        'image' => 'success',
                        'pdf' => 'info',
                        default => 'gray',
                    },
                ),

                Tables\Columns\TextColumn::make('deskripsi')->limit(50)->toggleable(),

                Tables\Columns\IconColumn::make('is_active')->label('Status')->boolean()->trueIcon('heroicon-o-check-circle')->falseIcon('heroicon-o-x-circle')->trueColor('success')->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Upload')->dateTime('d M Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tipe')->options([
                    'image' => 'Gambar',
                    'pdf' => 'PDF',
                ]),

                Tables\Filters\TernaryFilter::make('is_active')->label('Status Aktif'),
            ])
            ->actions([Tables\Actions\Action::make('view')->label('Lihat')->icon('heroicon-o-eye')->color('info')->modalHeading(fn(StrukturOrganisasi $record) => $record->nama)->modalContent(fn(StrukturOrganisasi $record) => view('filament.gjm.modals.view-struktur', compact('record')))->modalWidth('7xl'), Tables\Actions\Action::make('download')->label('Download')->icon('heroicon-o-arrow-down-tray')->color('success')->url(fn(StrukturOrganisasi $record) => asset('storage/' . $record->file_path))->openUrlInNewTab(), Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()->requiresConfirmation()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
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
            'index' => Pages\ListStrukturOrganisasiFakultas::route('/'),
            'create' => Pages\CreateStrukturOrganisasiFakultas::route('/create'),
            'edit' => Pages\EditStrukturOrganisasiFakultas::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        // Only show fakultas level struktur for this GJM
        $user = Auth::user();

        return parent::getEloquentQuery()
            ->where('level', 'fakultas')
            ->when($user && $user->fakultas_id, function ($query) use ($user) {
                return $query->where('fakultas_id', $user->fakultas_id);
            });
    }
}
