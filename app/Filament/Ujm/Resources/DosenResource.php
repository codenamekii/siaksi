<?php

namespace App\Filament\Ujm\Resources;

use App\Filament\Ujm\Resources\DosenResource\Pages;
use App\Models\Dosen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class DosenResource extends Resource
{
    protected static ?string $model = Dosen::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'SDM';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Dosen')
                ->schema([
                    Forms\Components\TextInput::make('nama')->label('Nama Lengkap')->required()->maxLength(255)->placeholder('Nama lengkap beserta gelar'),

                    Forms\Components\TextInput::make('nuptk')->label('NUPTK')->maxLength(50),

                    Forms\Components\TextInput::make('nidn')->label('NIDN/NIDK')->maxLength(50),

                    Forms\Components\Select::make('jabatan_akademik')
                        ->label('Jabatan Akademik')
                        ->options([
                            // Nilai enum yang umum digunakan
                            'Asisten Ahli' => 'Asisten Ahli',
                            'Lektor' => 'Lektor',
                            'Lektor Kepala' => 'Lektor Kepala',
                            'Guru Besar' => 'Guru Besar',
                            // Atau jika ada nilai lain, tambahkan di sini
                        ])
                        ->required()
                        ->searchable(),

                    Forms\Components\Select::make('pendidikan_terakhir')
                        ->label('Pendidikan Terakhir')
                        ->options([
                            'S1' => 'S1',
                            'S2' => 'S2',
                            'S3' => 'S3',
                        ])
                        ->required(),

                    Forms\Components\TextInput::make('bidang_keahlian')->label('Bidang Keahlian')->maxLength(255),
                ])
                ->columns(2),

            Forms\Components\Section::make('Kontak')
                ->schema([Forms\Components\TextInput::make('email')->label('Email')->email()->required()->maxLength(255), Forms\Components\TextInput::make('telepon')->label('No. Telepon/HP')->tel()->maxLength(20)])
                ->columns(2),

            Forms\Components\Section::make('Status')->schema([Forms\Components\Toggle::make('is_active')->label('Status Aktif')->default(true), Forms\Components\Hidden::make('program_studi_id')->default(fn() => Auth::user()->program_studi_id)]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable()->sortable(),

                Tables\Columns\TextColumn::make('nidn')->label('NIDN')->searchable(),

                Tables\Columns\BadgeColumn::make('jabatan_akademik')
                    ->label('Jabatan')
                    ->colors([
                        'gray' => 'Asisten Ahli',
                        'warning' => 'Lektor',
                        'success' => 'Lektor Kepala',
                        'danger' => 'Guru Besar',
                    ]),

                Tables\Columns\TextColumn::make('pendidikan_terakhir')->label('Pendidikan'),

                Tables\Columns\TextColumn::make('bidang_keahlian')->label('Keahlian')->limit(30),

                Tables\Columns\TextColumn::make('email')->label('Email')->toggleable(),

                Tables\Columns\IconColumn::make('is_active')->label('Status')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jabatan_akademik')
                    ->label('Jabatan')
                    ->options([
                        'Asisten Ahli' => 'Asisten Ahli',
                        'Lektor' => 'Lektor',
                        'Lektor Kepala' => 'Lektor Kepala',
                        'Guru Besar' => 'Guru Besar',
                    ]),

                Tables\Filters\SelectFilter::make('pendidikan_terakhir')
                    ->label('Pendidikan')
                    ->options([
                        'S1' => 'S1',
                        'S2' => 'S2',
                        'S3' => 'S3',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')->label('Status Aktif'),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
            ->defaultSort('nama', 'asc');
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
            'index' => Pages\ListDosens::route('/'),
            'create' => Pages\CreateDosen::route('/create'),
            'edit' => Pages\EditDosen::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->where('is_active', true)->count();
    }
}
