<?php

namespace App\Filament\Gjm\Resources;

use App\Filament\Gjm\Resources\UserResource\Pages;
use App\Models\User;
use App\Models\ProgramStudi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Kelola UJM';

    protected static ?string $modelLabel = 'Unit Jaminan Mutu';

    protected static ?string $pluralModelLabel = 'Unit Jaminan Mutu';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi User')
                ->schema([Forms\Components\TextInput::make('name')->label('Nama Lengkap')->required()->maxLength(255), Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true)->maxLength(255), Forms\Components\TextInput::make('password')->password()->required(fn($record) => $record === null)->dehydrateStateUsing(fn($state) => Hash::make($state))->dehydrated(fn($state) => filled($state))->maxLength(255)->label(fn($record) => $record ? 'Password Baru' : 'Password')->helperText(fn($record) => $record ? 'Kosongkan jika tidak ingin mengubah password' : null)])
                ->columns(3),

            Forms\Components\Section::make('Detail User')
                ->schema([
                    Forms\Components\Hidden::make('role')->default('ujm'),
                    Forms\Components\TextInput::make('nuptk')->label('NUPTK')->maxLength(255),
                    Forms\Components\TextInput::make('phone')->label('No. Telepon')->tel()->maxLength(255),
                    Forms\Components\Select::make('program_studi_id')
                        ->label('Program Studi')
                        ->options(ProgramStudi::where('is_active', true)->pluck('nama', 'id'))
                        ->required()
                        ->searchable()
                        ->helperText('Pilih program studi yang akan dikelola oleh UJM ini'),
                    Forms\Components\Toggle::make('is_active')->label('Status Aktif')->default(true),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(), Tables\Columns\TextColumn::make('email')->searchable(), Tables\Columns\TextColumn::make('programStudi.nama')->label('Program Studi')->badge()->color('info')->searchable(), Tables\Columns\TextColumn::make('nuptk')->label('NUPTK')->searchable()->toggleable(), Tables\Columns\TextColumn::make('phone')->label('Telepon')->toggleable(), Tables\Columns\IconColumn::make('is_active')->label('Status')->boolean()->trueIcon('heroicon-o-check-circle')->falseIcon('heroicon-o-x-circle')->trueColor('success')->falseColor('danger'), Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y')->sortable()->toggleable(isToggledHiddenByDefault: true)])
            ->filters([Tables\Filters\SelectFilter::make('program_studi')->relationship('programStudi', 'nama')->label('Program Studi'), Tables\Filters\TernaryFilter::make('is_active')->label('Status Aktif')])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->before(function (User $record) {
                    if ($record->programStudi) {
                        $record->programStudi->update(['ujm_id' => null]);
                    }
                }),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'ujm');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
