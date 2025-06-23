<?php

namespace App\Filament\Ujm\Resources;

use App\Filament\Ujm\Resources\TimUJMResource\Pages;
use App\Models\TimUJM;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TimUJMResource extends Resource
{
    protected static ?string $model = TimUJM::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Organisasi';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Tim UJM';

    protected static ?string $modelLabel = 'Anggota Tim UJM';

    protected static ?string $pluralModelLabel = 'Tim UJM';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Anggota')
                ->schema([
                    Forms\Components\TextInput::make('nama')->label('Nama Lengkap')->required()->maxLength(255)->placeholder('Nama lengkap beserta gelar'),

                    Forms\Components\Select::make('jabatan')
                        ->label('Jabatan')
                        ->options([
                            'Ketua UJM' => 'Ketua UJM',
                            'Sekretaris UJM' => 'Sekretaris UJM',
                            'Anggota UJM' => 'Anggota UJM',
                            'Auditor Internal' => 'Auditor Internal',
                        ])
                        ->required()
                        ->searchable(),

                    Forms\Components\TextInput::make('nuptk')->label('NUPTK/NIP')->maxLength(50),

                    Forms\Components\TextInput::make('email')->label('Email')->email()->required()->maxLength(255),

                    Forms\Components\TextInput::make('telepon')->label('No. Telepon/HP')->tel()->maxLength(20),
                ])
                ->columns(2),

            Forms\Components\Section::make('Foto Profil')->schema([
                Forms\Components\FileUpload::make('foto')
                    ->label('Foto')
                    ->image()
                    ->disk('public')
                    ->directory('tim-ujm/' . (Auth::user()->programStudi?->kode ?? 'default'))
                    ->visibility('public')
                    ->maxSize(2048) // 2MB
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth('300')
                    ->imageResizeTargetHeight('300')
                    ->imagePreviewHeight('200')
                    ->loadingIndicatorPosition('left')
                    ->panelAspectRatio('1:1')
                    ->panelLayout('integrated')
                    ->removeUploadedFileButtonPosition('right')
                    ->uploadButtonPosition('left')
                    ->uploadProgressIndicatorPosition('left')
                    ->helperText('Upload foto profil. Format: JPG, PNG. Maksimal 2MB. Rasio 1:1 (kotak)'),
            ]),

            Forms\Components\Section::make('Pengaturan')->schema([Forms\Components\Toggle::make('is_active')->label('Status Aktif')->default(true)->helperText('Nonaktifkan jika anggota sudah tidak aktif'), Forms\Components\Hidden::make('program_studi_id')->default(fn() => Auth::user()->program_studi_id)]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('DT_RowIndex')->label('No')->rowIndex(),

                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular()
                    ->width(60)
                    ->height(60)
                    ->disk('public')
                    ->getStateUsing(function ($record) {
                        // Return the path as stored in database
                        return $record->foto;
                    })
                    ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . urlencode($record->nama ?? 'User'))
                    ->extraImgAttributes(['loading' => 'lazy', 'class' => 'object-cover']),

                Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable()->sortable(),

                Tables\Columns\BadgeColumn::make('jabatan')
                    ->label('Jabatan')
                    ->colors([
                        'danger' => 'Ketua UJM',
                        'warning' => 'Sekretaris UJM',
                        'success' => 'Anggota UJM',
                        'primary' => 'Auditor Internal',
                    ]),

                Tables\Columns\TextColumn::make('nuptk')->label('NUPTK/NIP')->searchable()->toggleable(),

                Tables\Columns\TextColumn::make('email')->label('Email')->searchable()->toggleable(),

                Tables\Columns\TextColumn::make('telepon')->label('No. Telepon')->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('is_active')->label('Status')->boolean()->trueIcon('heroicon-o-check-circle')->falseIcon('heroicon-o-x-circle')->trueColor('success')->falseColor('danger'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jabatan')
                    ->label('Jabatan')
                    ->options([
                        'Ketua UJM' => 'Ketua UJM',
                        'Sekretaris UJM' => 'Sekretaris UJM',
                        'Anggota UJM' => 'Anggota UJM',
                        'Auditor Internal' => 'Auditor Internal',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->before(function ($record) {
                    // Delete photo when deleting record
                    if ($record->foto && Storage::disk('public')->exists($record->foto)) {
                        Storage::disk('public')->delete($record->foto);
                    }
                }),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
            ->defaultSort('jabatan', 'asc')
            ->reorderable('sort_order');
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
            'index' => Pages\ListTimUJMS::route('/'),
            'create' => Pages\CreateTimUJM::route('/create'),
            'edit' => Pages\EditTimUJM::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->where('is_active', true)->count();
    }
}
