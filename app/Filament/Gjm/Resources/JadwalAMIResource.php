<?php

namespace App\Filament\Gjm\Resources;

use App\Filament\Gjm\Resources\JadwalAMIResource\Pages;
use App\Models\JadwalAMI;
use App\Models\Fakultas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JadwalAMIResource extends Resource
{
    protected static ?string $model = JadwalAMI::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Audit Mutu Internal';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Jadwal AMI';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Jadwal')
                ->schema([
                    // Field WAJIB (Required di database)
                    Forms\Components\TextInput::make('nama_kegiatan')
                        ->label('Nama Kegiatan')
                        ->required() // WAJIB karena NOT NULL di database
                        ->maxLength(255),

                    Forms\Components\DatePicker::make('tanggal_mulai')
                        ->label('Tanggal Mulai')
                        ->required() // WAJIB karena NOT NULL di database
                        ->native(false),

                    Forms\Components\DatePicker::make('tanggal_selesai')
                        ->label('Tanggal Selesai')
                        ->required() // WAJIB karena NOT NULL di database
                        ->native(false)
                        ->afterOrEqual('tanggal_mulai'),

                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options([
                            'scheduled' => 'Terjadwal',
                            'in_progress' => 'Sedang Berlangsung',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ])
                        ->default('scheduled') // Ada default di database
                        ->required(),

                    // Field OPTIONAL (Nullable di database)
                    Forms\Components\Select::make('fakultas_id')->label('Fakultas')->options(Fakultas::pluck('nama', 'id'))->searchable()->placeholder('Pilih Fakultas (Optional)'),

                    Forms\Components\TextInput::make('tempat')->label('Tempat/Lokasi')->maxLength(255)->placeholder('Ruang Rapat / Online / Hybrid (Optional)'),

                    Forms\Components\Textarea::make('deskripsi')->label('Deskripsi')->rows(3)->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kegiatan')->label('Nama Kegiatan')->searchable()->sortable()->limit(50),

                Tables\Columns\TextColumn::make('fakultas.nama')->label('Fakultas')->default('-')->toggleable(),

                Tables\Columns\TextColumn::make('tempat')->label('Tempat')->default('-')->toggleable(),

                Tables\Columns\TextColumn::make('tanggal_mulai')->label('Tanggal Mulai')->date('d M Y')->sortable(),

                Tables\Columns\TextColumn::make('tanggal_selesai')->label('Tanggal Selesai')->date('d M Y')->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'info' => 'scheduled',
                        'warning' => 'in_progress',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(
                        fn(string $state): string => match ($state) {
                            'scheduled' => 'Terjadwal',
                            'in_progress' => 'Sedang Berlangsung',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                            default => $state,
                        },
                    ),

                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'scheduled' => 'Terjadwal',
                        'in_progress' => 'Sedang Berlangsung',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ]),

                Tables\Filters\SelectFilter::make('fakultas_id')->label('Fakultas')->options(Fakultas::pluck('nama', 'id')),
            ])
            ->actions([Tables\Actions\ViewAction::make(), Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
            ->defaultSort('tanggal_mulai', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJadwalAMIS::route('/'),
            'create' => Pages\CreateJadwalAMI::route('/create'),
            'edit' => Pages\EditJadwalAMI::route('/{record}/edit'),
        ];
    }
}
