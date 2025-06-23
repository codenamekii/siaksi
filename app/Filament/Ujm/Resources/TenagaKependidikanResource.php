<?php

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

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'SDM';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Tenaga Kependidikan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Tenaga Kependidikan')
                ->schema([
                    Forms\Components\TextInput::make('nama')->label('Nama Lengkap')->required()->maxLength(255),

                    Forms\Components\TextInput::make('nuptk')->label('NIP')->required()->maxLength(50)->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('jabatan')->label('Jabatan')->required()->maxLength(255),

                    Forms\Components\TextInput::make('unit_kerja')->label('Unit Kerja')->required()->maxLength(255),

                    Forms\Components\Select::make('pendidikan_terakhir')
                        ->label('Pendidikan Terakhir')
                        ->options([
                            'SD' => 'SD',
                            'SMP' => 'SMP',
                            'SMA/SMK' => 'SMA/SMK',
                            'D3' => 'D3',
                            'S1' => 'S1',
                            'S2' => 'S2',
                            'S3' => 'S3',
                        ])
                        ->required()
                        ->searchable(),

                    Forms\Components\Select::make('status_kepegawaian')
                        ->label('Status Kepegawaian')
                        ->options([
                            'Tetap' => 'Tetap',
                            'Kontrak' => 'Kontrak',
                        ])
                        ->required(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Kontak')->schema([Forms\Components\TextInput::make('email')->label('Email')->email()->required()->maxLength(255)->unique(ignoreRecord: true)]),

            Forms\Components\Section::make('Status')->schema([Forms\Components\Toggle::make('is_active')->label('Status Aktif')->default(true), Forms\Components\Hidden::make('program_studi_id')->default(fn() => Auth::user()->program_studi_id)]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nuptk')->label('NUPTK')->searchable()->sortable(),

                Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable()->sortable(),

                Tables\Columns\TextColumn::make('jabatan')->label('Jabatan')->searchable(),

                Tables\Columns\TextColumn::make('unit_kerja')->label('Unit Kerja'),

                Tables\Columns\BadgeColumn::make('status_kepegawaian')
                    ->label('Status')
                    ->colors([
                        'success' => 'Tetap',
                        'warning' => 'Kontrak',
                    ]),

                Tables\Columns\TextColumn::make('pendidikan_terakhir')->label('Pendidikan'),

                Tables\Columns\TextColumn::make('email')->label('Email')->toggleable(),

                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_kepegawaian')
                    ->label('Status Kepegawaian')
                    ->options([
                        'Tetap' => 'Tetap',
                        'Kontrak' => 'Kontrak',
                    ]),

                Tables\Filters\SelectFilter::make('pendidikan_terakhir')
                    ->label('Pendidikan')
                    ->options([
                        'SD' => 'SD',
                        'SMP' => 'SMP',
                        'SMA/SMK' => 'SMA/SMK',
                        'D3' => 'D3',
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
            'index' => Pages\ListTenagaKependidikans::route('/'),
            'create' => Pages\CreateTenagaKependidikan::route('/create'),
            'edit' => Pages\EditTenagaKependidikan::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->where('is_active', true)->count();
    }
}
